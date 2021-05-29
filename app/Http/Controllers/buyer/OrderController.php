<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Order;
use App\Book;
use App\PaymentMethod;
use App\Step;

class OrderController extends Controller
{
    public function showList()
    {
        $data = [
            "firstName" => User::getFirstName(session('id'))
        ];
        return view('pages.buyer.orders', $data);
    }

    public function showOrderDetail(Request $request)
    {
        $orderId = $request->orderId;
        $paymentId = Order::getPaymentId($orderId);
        $arrPaymentMethod = PaymentMethod::getArrPaymentMethodByPaymentIdForOrderInfoPage($paymentId);
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "order" => Order::getOrderForOrderInfoPage($orderId),
            "books" => Book::getBookDataForOrderInfoPage($orderId),
            "arrPaymentMethod" => $arrPaymentMethod,
            "arrStep" => Step::getPaymentMethodStepsForOrderInfoPage($arrPaymentMethod),
        ];
        return view('pages.buyer.info_order', $data);
    }
}
