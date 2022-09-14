<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Payment\OrderModel;

class GlobalController extends BaseController
{
    public function __construct()
    {
    }
    public function index()
    {
        $ordersMd = new OrderModel();
        $completedOrdersPaypal = 0;
        $query = $ordersMd->select('amount')->where(['payment_status' => 'completed', 'gateway' => 'paypal'])->findAll();
        foreach ($query as $key => $value) {
            $completedOrdersPaypal = $completedOrdersPaypal + floatval($value['amount']);
        }
        // return print_r($completedOrdersPaypal);

        $completedOrdersRazorpay = 0;
        $query = $ordersMd->select('amount')->where(['payment_status' => 'completed', 'gateway' => 'razorpay'])->findAll();
        foreach ($query as $key => $value) {
            $completedOrdersRazorpay = $completedOrdersRazorpay + floatval($value['amount']);
        }
        // return print_r($completedOrdersRazorpay);

        $failedOrdersPaypal = 0;
        $query = $ordersMd->select('amount')->where(['payment_status !=' => 'completed', 'gateway' => 'paypal', 'order_id !=' => NULL])->findAll();
        foreach ($query as $key => $value) {
            $failedOrdersPaypal = $failedOrdersPaypal + floatval($value['amount']);
        }
        // return print_r($failedOrdersPaypal);

        $failedOrdersRazorpay = 0;
        $query = $ordersMd->select('amount')->where(['payment_status !=' => 'completed', 'gateway' => 'razorpay', 'order_id !=' => NULL])->findAll();
        foreach ($query as $key => $value) {
            $failedOrdersRazorpay = $failedOrdersRazorpay + floatval($value['amount']);
        }
        // return print_r($failedOrdersRazorpay);

        $otherOrdersPaypal = 0;
        $query = $ordersMd->select('amount')->where(['gateway' => 'paypal', 'order_id is' => NULL])->findAll();
        foreach ($query as $key => $value) {
            $otherOrdersPaypal = $otherOrdersPaypal + floatval($value['amount']);
        }
        // return print_r($totalOrdersPaypal);

        $otherOrdersRazorpay = 0;
        $query = $ordersMd->select('amount')->where(['gateway' => 'razorpay', 'order_id is' => NULL])->findAll();
        foreach ($query as $key => $value) {
            $otherOrdersRazorpay = $otherOrdersRazorpay + floatval($value['amount']);
        }
        // return print_r($totalOrdersRazorpay);

        $paypalPayments = array(
            'gateway' => 'paypal',
            'currency' => 'EUR',
            'name' => 'PayPal',
            'other' => $otherOrdersPaypal,
            'completed' => $completedOrdersPaypal,
            'failed' => $failedOrdersPaypal,
            'total' => $otherOrdersPaypal + $completedOrdersPaypal + $failedOrdersPaypal,
            // 'other_currency' => number_to_currency($otherOrdersPaypal, 'EUR', 'en_US', 2),
            'completed_currency' => number_to_currency($completedOrdersPaypal, 'EUR', 'en_US', 2),
            'failed_currency' => number_to_currency($failedOrdersPaypal, 'EUR', 'en_US', 2),
            'total_currency' => number_to_currency($otherOrdersPaypal + $completedOrdersPaypal + $failedOrdersPaypal, 'EUR', 'en_US', 2),
        );
        $razorpayPayments = array(
            'gateway' => 'razorpay',
            'currency' => 'INR',
            'name' => 'Razorpay',
            'other' => $otherOrdersRazorpay,
            'completed' => $completedOrdersRazorpay,
            'failed' => $failedOrdersRazorpay,
            'total' => $otherOrdersRazorpay + $completedOrdersRazorpay + $failedOrdersRazorpay,
            // 'other_currency' => number_to_currency($otherOrdersRazorpay, 'INR', 'en_US', 2),
            'completed_currency' => number_to_currency($completedOrdersRazorpay, 'INR', 'en_US', 2),
            'failed_currency' => number_to_currency($failedOrdersRazorpay, 'INR', 'en_US', 2),
            'total_currency' => number_to_currency($otherOrdersRazorpay + $completedOrdersRazorpay + $failedOrdersRazorpay, 'INR', 'en_US', 2),
        );
        // return print_r($paymentAmounts);

        // $completedOrdersRazorpay = $ordersMd->select('amount')->where('payment_status', 'completed')->findAll();

        // return print_r(session()->get('user'));

        $this->data['dashboard'] = true;
        $this->data['paypalPayments'] = $paypalPayments;
        $this->data['razorpayPayments'] = $razorpayPayments;

        return view('Admin/Pages/dashboard', $this->data);
    }
}
