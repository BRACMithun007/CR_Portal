<?php

namespace App\Libraries;
use Carbon\Carbon;

class CommonFunction
{
    public static function isValidAgeBasedOnLoanDuration($dateOfBirth,$loan_duration_month){
        $days = intval(Carbon::parse($dateOfBirth)->diff(Carbon::now())->format('%d'));
        $months = intval(Carbon::parse($dateOfBirth)->diff(Carbon::now())->format('%m'));
        $years = intval(Carbon::parse($dateOfBirth)->diff(Carbon::now())->format('%y'));
        $memberAgeInMonths = ($years*12) + $months;

        if(($memberAgeInMonths > (840-$loan_duration_month)) && $days != 0){ // 70 years - N
            return false;
        }else if(($memberAgeInMonths == (840-$loan_duration_month)) && $days != 0) { // 70 years - N
            return false;
        }else{
            return true;
        }
    }

    public static function getAgeSlab($dateOfBirth,$loan_duration_month){
        $days = intval(Carbon::parse($dateOfBirth)->diff(Carbon::now())->format('%d'));
        $months = intval(Carbon::parse($dateOfBirth)->diff(Carbon::now())->format('%m'));
        $years = intval(Carbon::parse($dateOfBirth)->diff(Carbon::now())->format('%y'));
        $memberAgeInMonths = ($years*12) + $months;

        if(($memberAgeInMonths < (780-$loan_duration_month))){ // 65 years - N
            return '18 to 65';
        }else if(($memberAgeInMonths == (780-$loan_duration_month)) && $days == 0){ // 65 years - N
            return '18 to 65';
        }else{
            return '65 to 70';
        }
    }

    public static function commonResponse($responseCode, $html = '',$message = '')
    {
        http_response_code(200);
        header('Content-Type:application/json');

        $responseData = [
            'html' => $html,
            'responseCode' => $responseCode,
            'message' => $message,
        ];

        echo json_encode($responseData,200);
        exit;
    }

}
