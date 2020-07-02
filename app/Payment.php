<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    const PAY_S = 'Company';
    const PAY_R = 'OtherCompany';

    protected $fillable = ['sender', 'receiver', 'doc_type', 'count', 'payer'];

    public static function saveFromCsv($item){
        $prices = [2.5, 1.5, 1.1, 0.8, 0.6, 0.4];
        $coefficient = function ($payer){
            return  $payer == self::PAY_S ? 0.2 : 0.5;
        };

        $item = mb_substr($item, 0, -1);
        $item = explode(',', $item);
        $payment = new Payment();
        $payment->sender = $item[0];
        $payment->receiver = $item[1];
        $payment->doc_type = $item[2];
        $payment->count = $item[3];
        $payment->payer = $item[4] == 'S' ? self::PAY_S : self::PAY_R;

        if ($payment->count < 10){
            $payment->sum = $payment->count * $prices[0] * $coefficient($payment->payer);
        }elseif ($payment->count > 10000){
            $payment->sum = $payment->count * $prices[5] * $coefficient($payment->payer);
        }elseif ($payment->count > 1000){
            $payment->sum = $payment->count * $prices[4] * $coefficient($payment->payer);
        }elseif ($payment->count > 300){
            $payment->sum = $payment->count * $prices[3] * $coefficient($payment->payer);
        }elseif ($payment->count > 50){
            $payment->sum = $payment->count * $prices[2] * $coefficient($payment->payer);
        }elseif ($payment->count >= 10){
            $payment->sum = $payment->count * $prices[1] * $coefficient($payment->payer);
        }else{
            $payment->sum = 0;
        }
        $payment->save();
        return '';
    }
}
