<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{

    public function create(Request $request)
    {
        $orderId = Order::createOrder($request->paymentMethod);
        Order::updatePaymentCodeFromMidtrans($orderId);
        return $orderId;
    }

    public function whetherTheTransactionIsPendingOrSuccess(Request $request)
    {
        return Order::whetherTheTransactionIsPendingOrSuccess($request->bookId);
    }

    public function getUserOrdersForOrdersPage()
    {
        return Order::getUserOrders(session('id'));
    }

    public function getBooksByOrderId(Request $request)
    {
        return Order::getBooksByOrderId($request->orderId);
    }

    public function getPaymentCodeFromMidtrans(Request $request)
    {
        return Order::getPaymentCodeFromMidtrans($request->get('orderId'), $request->get('paymentMethod'));
    }
}
