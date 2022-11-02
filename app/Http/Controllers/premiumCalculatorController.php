<?php

namespace App\Http\Controllers;

use App\changeRequestMaster;
use App\changeRequestUpdates;
use App\configLoanPremiumCalc;
use App\Libraries\aclHandler;
use App\Libraries\CommonFunction;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class premiumCalculatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (aclHandler::hasModuleAccess(['calculators']) == false){
            die('No access !');
        }
        
        return view('premium.loan_premium');
    }

    public function loanPremiumResult(Request $request)
    {
        if (aclHandler::hasModuleAccess(['calculators']) == false){
            return response()->json( ['responseCode'=>0,'message'=>'No permission']);
        }

        $rules = [
            'payment_type'       => 'required',
            'premium_type'       => 'required',
            'loan_duration'      => 'required',
            'loan_amount'        => 'required',
            'borrower_birth_day' => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required fields']);
        }

        $payment_type = trim($request->get('payment_type'));
        $premium_type = trim($request->get('premium_type'));
        $loan_duration_month = $request->get('loan_duration');
        $loan_amount = trim($request->get('loan_amount'));
        $borrower_birth_day = $request->get('borrower_birth_day');
        $second_insurer_birth_day = $request->get('second_insurer_birth_day');

        $dateOfBirthBorrower = date('Y-m-d',strtotime($borrower_birth_day));
        $ageBorrower = Carbon::parse($dateOfBirthBorrower)->age;
        $displayBorrowerAge = Carbon::parse($dateOfBirthBorrower)->diff(Carbon::now())->format('%y years, %m months and %d days');
        if($ageBorrower < 18){
            return response()->json( ['responseCode'=>0,'message'=>'Borrower age is <b>'.$displayBorrowerAge.'</b> , which is not eligible']);
        }

        if(! CommonFunction::isValidAgeBasedOnLoanDuration($dateOfBirthBorrower,$loan_duration_month)){ // 70 years - N
            return response()->json( ['responseCode'=>0,'message'=>'Borrower age is <b>'.$displayBorrowerAge.'</b> , which will exit age boundary by considering loan duration ']);
        }

        $ageSecondInsurer = 0;
        if($premium_type == 'Double'){
            $dateOfBirthSecondInsurer = date('Y-m-d',strtotime($second_insurer_birth_day));
            $ageSecondInsurer = Carbon::parse($dateOfBirthSecondInsurer)->age;
            $displaySecondInsurerAge = Carbon::parse($dateOfBirthSecondInsurer)->diff(Carbon::now())->format('%y years, %m months and %d days');
            if($ageSecondInsurer < 18){
                return response()->json( ['responseCode'=>0,'message'=>'Second insurer age is <b>'.$ageSecondInsurer.'</b> Years , which is not eligible']);
            }

            if(! CommonFunction::isValidAgeBasedOnLoanDuration($dateOfBirthSecondInsurer,$loan_duration_month)){ // 70 years - N
                return response()->json( ['responseCode'=>0,'message'=>'Second insurer age is <b>'.$displaySecondInsurerAge.'</b> , which will exit age boundary by considering loan duration ']);
            }
        }

        $loanPremiumConf = configLoanPremiumCalc::where('status',1)->first();
        switch ($premium_type) {
            case "Single":
                $this->premiumCalcForSingleInsurer($loanPremiumConf,$request);
                break;
            case "Double":
                $this->premiumCalcForDoubleInsurer($loanPremiumConf,$request);
                break;
            default:
                return response()->json( ['responseCode'=>0,'message'=>'Invalid request']);
        }


//        $public_html = strval(view("calculators.premium.loan_premium_result", compact('crNoteData')));
//
//        return response()->json( ['responseCode'=>1,'noteList'=>$public_html,'message'=>'Successfully updated']);
    }


    public function premiumCalcForSingleInsurer($loanPremiumConf,$request){

        $payment_type = trim($request->get('payment_type'));
        $premium_type = trim($request->get('premium_type'));
        $loan_duration_month = intval($request->get('loan_duration'));
        $loan_amount = intval($request->get('loan_amount'));
        $borrower_birth_day = $request->get('borrower_birth_day');
        $second_insurer_birth_day = $request->get('second_insurer_birth_day');

        $dateOfBirthBorrower = date('Y-m-d',strtotime($borrower_birth_day));
        $ageBorrower = Carbon::parse($dateOfBirthBorrower)->age;

        $displayBorrowerAge = Carbon::parse($dateOfBirthBorrower)->diff(Carbon::now())->format('%y years, %m months and %d days');
        $ageSlab = CommonFunction::getAgeSlab($dateOfBirthBorrower,$loan_duration_month);

        if($ageSlab == '18 to 65'){
            $premiumRateInThousand = $loanPremiumConf->rate_in_thousand_borrower_less_65;
            $premiumAmountInThousand = ($premiumRateInThousand/12)*$loan_duration_month;
            if($loan_amount >= 2000){
                $premiumAmountOverLoan = round(($premiumAmountInThousand*$loan_amount)/1000);
            }else{
                $premiumAmountOverLoan = number_format((float)($premiumAmountInThousand*$loan_amount)/1000, 2, '.', '');
            }
        }else{
            $premiumRateInThousand = $loanPremiumConf->rate_in_thousand_borrower_above_65;
            $premiumAmountInThousand = ($premiumRateInThousand/12)*$loan_duration_month;
            if($loan_amount >= 2000){
                $premiumAmountOverLoan = round(($premiumAmountInThousand*$loan_amount)/1000);
            }else{
                $premiumAmountOverLoan = number_format((float)($premiumAmountInThousand*$loan_amount)/1000, 2, '.', '');
            }
        }

        $resultDataArray = [
            'displayBorrowerAge' =>$displayBorrowerAge,
            'borrowerAgeSlab' =>$ageSlab,
            'premiumRateInThousand' =>$premiumRateInThousand,
            'premiumAmountOverLoan' =>$premiumAmountOverLoan,
            'payment_type' =>$payment_type,
            'premium_type' =>$premium_type,
            'loan_amount' =>$loan_amount,
        ];
        if ($payment_type == 'Bullet'){
            $resultDataArray['premiumRateInThousand'] =  $premiumRateInThousand * 1.5;
            $resultDataArray['premiumAmountOverLoan'] =  $premiumAmountOverLoan * 1.5;
        }

        $public_html = strval(view("calculators.premium.loan_premium_result_single_policy", compact('resultDataArray')));
        CommonFunction::commonResponse(1,$public_html,'');

    }

    public function premiumCalcForDoubleInsurer($loanPremiumConf,$request){
        $payment_type = trim($request->get('payment_type'));
        $premium_type = trim($request->get('premium_type'));
        $loan_duration_month = intval($request->get('loan_duration'));
        $loan_amount = intval($request->get('loan_amount'));
        $borrower_birth_day = $request->get('borrower_birth_day');
        $second_insurer_birth_day = $request->get('second_insurer_birth_day');

        $dateOfBirthBorrower = date('Y-m-d',strtotime($borrower_birth_day));
        $displayBorrowerAge = Carbon::parse($dateOfBirthBorrower)->diff(Carbon::now())->format('%y years, %m months and %d days');
        $ageSlabBorrower = CommonFunction::getAgeSlab($dateOfBirthBorrower,$loan_duration_month);

        $dateOfBirthSecondInsurer = date('Y-m-d',strtotime($second_insurer_birth_day));
        $displaySecondInsurerAge = Carbon::parse($dateOfBirthSecondInsurer)->diff(Carbon::now())->format('%y years, %m months and %d days');
        $ageSlabSecondInsurer = CommonFunction::getAgeSlab($dateOfBirthSecondInsurer,$loan_duration_month);

        if($ageSlabBorrower == '65 to 70' && $ageSlabSecondInsurer == '65 to 70'){
            $premiumRateInThousandForBorrower = $loanPremiumConf->rate_in_thousand_borrower_less_65;
            $premiumRateInThousandForSecondInsure = $loanPremiumConf->rate_in_thousand_second_less_65;
            $totalPremiumRateInThousand = $premiumRateInThousandForBorrower+$premiumRateInThousandForSecondInsure;
            $premiumAmountInThousand = ($totalPremiumRateInThousand/12)*$loan_duration_month;
            if($loan_amount >= 2000){
                $premiumAmountOverLoan = round(($premiumAmountInThousand*$loan_amount)/1000);
            }else{
                $premiumAmountOverLoan = number_format((float)($premiumAmountInThousand*$loan_amount)/1000, 2, '.', '');
            }

        }else if($ageSlabBorrower == '65 to 70' && $ageSlabSecondInsurer == '18 to 65'){
            $premiumRateInThousandForBorrower = $loanPremiumConf->rate_in_thousand_borrower_above_65;
            $premiumRateInThousandForSecondInsure = $loanPremiumConf->rate_in_thousand_second_less_65;
            $totalPremiumRateInThousand = $premiumRateInThousandForBorrower+$premiumRateInThousandForSecondInsure;
            $premiumAmountInThousand = ($totalPremiumRateInThousand/12)*$loan_duration_month;
            if($loan_amount >= 2000){
                $premiumAmountOverLoan = round(($premiumAmountInThousand*$loan_amount)/1000);
            }else{
                $premiumAmountOverLoan = number_format((float)($premiumAmountInThousand*$loan_amount)/1000, 2, '.', '');
            }

        }else if($ageSlabBorrower == '18 to 65' && $ageSlabSecondInsurer == '65 to 70'){
            $premiumRateInThousandForBorrower = $loanPremiumConf->rate_in_thousand_borrower_less_65;
            $premiumRateInThousandForSecondInsure = $loanPremiumConf->rate_in_thousand_second_above_65;
            $totalPremiumRateInThousand = $premiumRateInThousandForBorrower+$premiumRateInThousandForSecondInsure;
            $premiumAmountInThousand = ($totalPremiumRateInThousand/12)*$loan_duration_month;
            if($loan_amount >= 2000){
                $premiumAmountOverLoan = round(($premiumAmountInThousand*$loan_amount)/1000);
            }else{
                $premiumAmountOverLoan = number_format((float)($premiumAmountInThousand*$loan_amount)/1000, 2, '.', '');
            }

        }else if($ageSlabBorrower == '18 to 65' && $ageSlabSecondInsurer == '18 to 65'){
            $premiumRateInThousandForBorrower = $loanPremiumConf->rate_in_thousand_borrower_less_65;
            $premiumRateInThousandForSecondInsure = $loanPremiumConf->rate_in_thousand_borrower_less_65;
            $totalPremiumRateInThousand = $premiumRateInThousandForBorrower+$premiumRateInThousandForSecondInsure;
            $premiumAmountInThousand = ($totalPremiumRateInThousand/12)*$loan_duration_month;
            if($loan_amount >= 2000){
                $premiumAmountOverLoan = round(($premiumAmountInThousand*$loan_amount)/1000);
            }else{
                $premiumAmountOverLoan = number_format((float)($premiumAmountInThousand*$loan_amount)/1000, 2, '.', '');
            }
        }

        $resultDataArray = [
            'displayBorrowerAge' =>$displayBorrowerAge,
            'displaySecondInsureAge' =>$displaySecondInsurerAge,
            'borrowerAgeSlab' =>$ageSlabBorrower,
            'secondInsureAgeSlab' =>$ageSlabSecondInsurer,
            'premiumRateInThousandForBorrower' =>$premiumRateInThousandForBorrower,
            'premiumRateInThousandForSecondInsure' =>$premiumRateInThousandForSecondInsure,
            'totalPremiumRateInThousand' =>$totalPremiumRateInThousand,
            'premiumAmountOverLoan' =>$premiumAmountOverLoan,
            'payment_type' =>$payment_type,
            'premium_type' =>$premium_type,
            'loan_amount' =>$loan_amount,
        ];

        if ($payment_type == 'Bullet'){
            $resultDataArray['premiumRateInThousandForBorrower'] =  $premiumRateInThousandForBorrower * 1.5;
            $resultDataArray['premiumRateInThousandForSecondInsure'] =  $premiumRateInThousandForSecondInsure * 1.5;
            $resultDataArray['totalPremiumRateInThousand'] =  $totalPremiumRateInThousand * 1.5;
            $resultDataArray['premiumAmountOverLoan'] =  $premiumAmountOverLoan * 1.5;
        }

        $public_html = strval(view("calculators.premium.loan_premium_result_double_policy", compact('resultDataArray')));
        CommonFunction::commonResponse(1,$public_html,'');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
