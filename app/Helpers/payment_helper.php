<?php

// function createOrderSelf(){}




// Razorpay functions

use App\Models\Payment\OrderModel;
use Razorpay\Api\Api as RazorpayApi;

function razorpayCreateOrder($payload)
{
    $response = ['success' => false, 'message' => 'Unable to create order. please try after some time, or contact site administrator.', 'data' => []];
    // first create order locally
    $order = [
        'gateway' => 'razorpay',
        'amount' => $payload['amount'],
        'product_information' => json_encode($payload['product_information']),
        'product_name' => $payload['product_name'],
        'user_name' => $payload['user_name'],
        'user_email' => $payload['user_email'],
        'user_phone' => $payload['user_phone'],
        'other_user_info' => json_encode($payload['other_user_info']),
        'currency' => 'INR',
        'receipt' => uniqidReal(),
    ];
    $orderDb = new OrderModel();
    if ($orderDb->save($order)) {
        $thisOrder = $orderDb->where('receipt', $order['receipt'])->first();
        // then create order on razorpay
        $api = new RazorpayApi(RAZORPAY_KEY_ID, RAZORPAY_SECRET);
        $razorpayOrderData = [
            'receipt' => $thisOrder['receipt'],
            'amount' => intval($thisOrder['amount']) * 100,
            'currency' => 'INR',
            'notes' => json_decode($thisOrder['product_information'], true),
        ];
        $razorpayOrder = $api->order->create($razorpayOrderData);
        return $razorpayOrder;
        $thisOrder['gateway_order_response'] = $razorpayOrder;
        $orderDb->save($thisOrder);
        if (isset($razorpayOrder['id'], $razorpayOrder['status'], $razorpayOrder['created_at']) && $razorpayOrder['status'] == 'created') {
            // then ammend local order values
            $thisOrder['order_id'] = $razorpayOrder['id'];
            $thisOrder['order_created_date'] = $razorpayOrder['created_at'];

            if ($orderDb->save($thisOrder)) {
                // then return the response with success
                $response['message'] = 'Order created succesfully.';
                $response['success'] = true;
                $response['data'] = json_encode(array(
                    'response' => $razorpayOrder,
                    'order' => $thisOrder
                ));
            } else {
                $response['message'] = 'Unable to create order on local gateway. please try after some time, or contact site administrator.';
            }
        } else {
            $response['message'] = 'Unable to create order on gateway. please try after some time, or contact site administrator.';
        }
    }
    return $response;
}
// function razorpayVerifyPaymentSignature(){}