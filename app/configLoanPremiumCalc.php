<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class configLoanPremiumCalc extends Model
{
    protected $table = 'config_loan_premium_calc';
    protected $connection = 'mysql';

    protected $fillable = [
        'id',
        'rate_in_thousand_borrower_less_65',
        'rate_in_thousand_borrower_above_65',
        'rate_in_thousand_second_less_65',
        'rate_in_thousand_second_above_65',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];
}
