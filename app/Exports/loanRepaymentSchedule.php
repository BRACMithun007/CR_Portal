<?php

namespace App\Exports;

use App\Libraries\BusinessDaysCalculator;
use Maatwebsite\Excel\Concerns\FromCollection;
use DateTime;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class loanRepaymentSchedule implements FromView
{
    public $loan_amount = 0;
    public $loan_period = 0;
    public $interest_percentage = 0;

    public function __construct($loan_amount,$loan_period,$interest_percentage){
        $this->loan_amount=$loan_amount;
        $this->loan_period=$loan_period;
        $this->interest_percentage=$interest_percentage;
    }

    public function view(): View
    {
        $loan_amount = $this->loan_amount;
        $loan_period = $this->loan_period;
        $interest = $this->interest_percentage;

        // Calculation per thousand
        $amount = 1000;
        $rate = ($interest/100) / 12; // Monthly interest rate
        $term = $loan_period; // Term in months
        $emi = $amount * $rate * (pow(1 + $rate, $term) / (pow(1 + $rate, $term) - 1));
        $monthlyEmi = ceil($emi);
        $EmiInOneTaka = $monthlyEmi/1000;


        $loanConfData = [
            'interest_rate' => $interest,
            'monthly_pay_factor' => $EmiInOneTaka,
            'disbursement_no_of_date' => 7,
            'period_in_month' => $loan_period,
        ];

        $total_interest = intval($this->totalInterestCalc($loan_amount,$loanConfData['interest_rate'],$loanConfData['period_in_month']));
        $disbursement_date = $this->businessDayCalcFromNow(7);
        $provision_start_date = $this->businessDayCalcFromSpecificDate($disbursement_date,30);

        $headerCalcData = [
            'monthly_payment' => round($loan_amount*$loanConfData['monthly_pay_factor']),
            'disbursement_date' => date('M d, Y', strtotime($disbursement_date)),
            'provision_start_date' => date('M d, Y', strtotime($provision_start_date))
        ];


        //*********************** repayment schedule calculation *************************
        $startCountDate = $disbursement_date;
        $remainingPrincipal = $loan_amount;
        $allScheduleData = [];
        $interestFactorPerDay = ($loanConfData['interest_rate']/100)/365;

        $specialCountFlip = 1;
        $grandTotalInterest = 0;
        for ($i = 1; $i<$loan_period+1 ; $i++){

            $dateDifference = ($specialCountFlip % 2 == 0)?30:31;
            $nextInstallmentDate = $this->businessDayCalcFromSpecificDate($startCountDate,$dateDifference);

            if($i == $loan_period){
                $monthlyPrincipal = $remainingPrincipal;
                $monthlyInterest = round($interestFactorPerDay*$dateDifference*$monthlyPrincipal,0);
                $monthlyTotalPayment =  $remainingPrincipal+$monthlyInterest;
            }else{
                if($i == 1){$dateDifference = 29;}else{$specialCountFlip ++;}
                $monthlyInterest = round($interestFactorPerDay*$dateDifference*$remainingPrincipal,0);
                $monthlyTotalPayment = $headerCalcData['monthly_payment'];
                $monthlyPrincipal = $monthlyTotalPayment - intval($monthlyInterest);
            }

            $grandTotalInterest += $monthlyInterest;
            if($specialCountFlip % 6 == 0){$specialCountFlip =1;}

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

        $headerCalcData['total_interest'] = $grandTotalInterest;
        $headerCalcData['total_realizable'] = $loan_amount+$headerCalcData['total_interest'];
        return view('exports.loanRepaymentSchedule', [
            'loanConfData' => $loanConfData,
            'headerCalcData' => $headerCalcData,
            'allScheduleData' => $allScheduleData
        ]);
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
            [
                new DateTime("2022-12-16"),
                new DateTime("2023-02-21"),
                new DateTime("2023-03-08"),
                new DateTime("2023-03-26"),
                new DateTime("2023-04-18"),
                new DateTime("2023-04-23"),
                new DateTime("2023-05-01"),
                new DateTime("2023-06-28"),
                new DateTime("2023-06-29")
            ],
            [BusinessDaysCalculator::SATURDAY, BusinessDaysCalculator::FRIDAY]
        );
        $calculator->addBusinessDays(1); // Add three business days
        return $calculator->getDate()->format('Y-m-d H:i:s');
    }
}
