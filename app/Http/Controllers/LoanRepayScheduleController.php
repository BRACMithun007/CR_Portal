<?php

namespace App\Http\Controllers;

use App\Libraries\aclHandler;
use App\Libraries\BusinessDaysCalculator;
use App\LoanRepayConfig;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanRepayScheduleController extends Controller
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

        return view('loan.loan_calc');
    }

    /**
     * @param Request $request
     */
    public function getRepaySchedule(Request $request)
    {

        $rules = [
            'loan_amount'  => 'required',
            'loan_period'    => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $loan_amount = intval($request->get('loan_amount'));
        $loan_period = intval($request->get('loan_period'));

        $loanConfResult = LoanRepayConfig::where('period_in_month','=',$loan_period)
                                        ->get();
        $loanConfData = [];
        foreach ($loanConfResult as $result){
            if ($loan_amount >= $result->loan_amount_start && $loan_amount <= $result->loan_amount_end){
                $loanConfData = [
                    'interest_rate' => $result->interest_rate,
                    'monthly_pay_factor' => $result->monthly_pay_factor,
                    'disbursement_no_of_date' => $result->disbursement_no_of_date,
                    'period_in_month' => $result->period_in_month,
                ];
                break;
            }
        }

        if ( empty($loanConfData) ) {
            return response()->json( ['responseCode'=>0,'message'=>'Not valid input']);
        }

        $total_interest = intval($this->totalInterestCalc($loan_amount,$result->interest_rate,$loan_period));
        $disbursement_date = $this->businessDayCalcFromNow(7);
        $provision_start_date = $this->businessDayCalcFromSpecificDate($disbursement_date,30);

        $headerCalcData = [
            'monthly_payment' => round($loan_amount*$result->monthly_pay_factor),
            'total_interest' => $total_interest,
            'total_realizable' => $loan_amount+$total_interest,
            'disbursement_date' => date('M d, Y', strtotime($disbursement_date)),
            'provision_start_date' => date('M d, Y', strtotime($provision_start_date))
        ];


      //  dd($loanConfData['interest_rate']/100);
        //*********************** repayment schedule calculation *************************
        $startCountDate = $disbursement_date;
        $remainingPrincipal = $loan_amount;
        $allScheduleData = [];
        $interestFactor = ($loanConfData['interest_rate']/100)/365;
        $interestFactorPerDay = floatval(number_format((float)$interestFactor, 6, '.', ''));

        for ($i = 1; $i<$loan_period+1 ; $i++){
            $nextInstallmentDate = $this->businessDayCalcFromSpecificDate($startCountDate,30);
            $dateDifference = (date_diff(date_create($startCountDate), date_create($nextInstallmentDate)))->days;
            $monthlyInterest = round($interestFactorPerDay*$dateDifference*$remainingPrincipal,0);

            $monthlyTotalPayment = ($i == $loan_period) ? $remainingPrincipal : $headerCalcData['monthly_payment'];
            $monthlyPrincipal = $monthlyTotalPayment - intval($monthlyInterest);
            $monthlyBeginningBalance = $remainingPrincipal;
            $monthlyEndingBalance = ($i == $loan_period) ? 0 : $remainingPrincipal - $monthlyPrincipal;

            $startCountDate = $nextInstallmentDate;
            $remainingPrincipal = $monthlyEndingBalance;

            $scheduleData['sl'] = $i;
            $scheduleData['payment_date'] = date('M d, Y', strtotime($nextInstallmentDate));
            $scheduleData['beginning_balance'] = $monthlyBeginningBalance;
            $scheduleData['payment'] = $monthlyTotalPayment;
            $scheduleData['principal'] = $monthlyPrincipal;
            $scheduleData['no_of_days'] = $dateDifference;
            $scheduleData['interest'] = $monthlyInterest;
            $scheduleData['ending_balance'] = $monthlyEndingBalance;

            $allScheduleData[] = $scheduleData;
        }
        //***********************************************************

        $public_html = strval(view("loan.repay_schedule_template", compact('loanConfData','headerCalcData','allScheduleData')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);

    }

    /**
     * @param $loan_amount
     * @param $interest_rate
     * @param $loan_period
     * @return false|float
     */
    public function totalInterestCalc($loan_amount,$interest_rate,$loan_period)
    {

        $princ =$loan_amount; //principal amount
        $term = $loan_period; //months
        $intr =$interest_rate/ 1200; //get percentage

        return ceil(($princ * $intr / (1 - (pow(1/(1 + $intr), $term))))*$term) - $princ; # This is for Total interest
    }


    /**
     * @param $loan_amount
     * @param $interest_rate
     * @param $loan_period
     * @return float|int
     */
    public function monthlyPaymentCalc($loan_amount,$interest_rate,$loan_period)
    {
        $amount = $loan_amount;
        $rate = ($interest_rate/100) / 12; // Monthly interest rate
        $term = $loan_period; // Term in months

        return $amount * $rate * (pow(1 + $rate, $term) / (pow(1 + $rate, $term) - 1));
    }


    /**
     * @param $addedDays
     * @return string
     */
    public function businessDayCalcFromNow($addedDays){
        $oneDayPrev = date('Y-m-d', strtotime(' + '.($addedDays-1).' days'));
        $calculator = new BusinessDaysCalculator(
            new DateTime($oneDayPrev), // Start Today
            [new DateTime("2022-12-16")],
            [BusinessDaysCalculator::SATURDAY, BusinessDaysCalculator::FRIDAY]
        );
        $calculator->addBusinessDays(1); // Add three business days
        return $calculator->getDate()->format('Y-m-d H:i:s');
    }


    /**
     * @param $startDate
     * @param $addedDays
     * @return string
     */
    public function businessDayCalcFromSpecificDate($startDate,$addedDays){
        $oneDayPrev = date('Y-m-d', strtotime("+".($addedDays-1)." day", strtotime($startDate)));
        $calculator = new BusinessDaysCalculator(
            new DateTime($oneDayPrev), // Start Today
            [new DateTime("2022-12-16")],
            [BusinessDaysCalculator::SATURDAY, BusinessDaysCalculator::FRIDAY]
        );
        $calculator->addBusinessDays(1); // Add three business days
        return $calculator->getDate()->format('Y-m-d H:i:s');
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
