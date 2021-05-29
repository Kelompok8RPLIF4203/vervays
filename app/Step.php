<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Step
{
    public static function getPaymentMethodStepsForOrderInfoPage($arrPaymentMethod)
    {
        foreach ($arrPaymentMethod as $paymentMethod) {
            $data[$paymentMethod->name] = DB::table('steps')
                                                ->where('paymentMethodId', $paymentMethod->id)
                                                ->orderBy('order', 'asc')
                                                ->pluck('step');
        }
        return $data;
    }
}
