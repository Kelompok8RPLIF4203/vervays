<?php

namespace App;

use Illuminate\Support\Facades\DB;

class PaymentMethod
{

    public static function getArrPaymentMethodByPaymentIdForOrderInfoPage($paymentId)
    {
        return DB::table('payment_methods')
                    ->where('paymentId', $paymentId)
                    ->select('id', 'name')
                    ->get();
    }
}
