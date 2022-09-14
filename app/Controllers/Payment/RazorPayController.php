<?php

namespace App\Controllers\Payment;

use App\Controllers\BaseController;
use App\Models\Payment\OrderModel;
use Razorpay\Api\Api;

class RazorPayController extends BaseController
{
    public function createOrder()
    {
        $orderData = $this->request->getPost();
        $orderDb = new OrderModel();

        $response = ['success' => false, 'message' => 'Unable to create order. please try after some time, or contact site administrator.', 'data' => []];
        $thisOrder = $orderDb->localOrderCreate($orderData, 'razorpay', 'INR');
        if ($thisOrder) {
            // then create order on razorpay
            $api = new Api(PAZORPAY_CREDENTIALS[RAZORPAY_ENVIRONMENT]['KEY_ID'], PAZORPAY_CREDENTIALS[RAZORPAY_ENVIRONMENT]['SECRET']);
            $razorpayOrderData = array(
                'receipt' => $thisOrder['receipt'],
                'amount' => intval($thisOrder['amount']) * 100,
                'currency' => 'INR',
                'notes' => array('product_information' => $thisOrder['product_information']),
            );
            // return $razorpayOrderData;
            try {
                $razorpayOrder = $api->order->create($razorpayOrderData);

                // $response['data'] = $razorpayOrder['id'];
                // return $response;

                if (isset($razorpayOrder['id'], $razorpayOrder['status'], $razorpayOrder['created_at']) && $razorpayOrder['status'] == 'created') {
                    // then ammend local order values
                    $thisOrder['order_id'] = $razorpayOrder['id'];
                    $thisOrder['order_created_date'] = $razorpayOrder['created_at'];
                    $thisOrder['gateway_order_response'] = json_encode(array(
                        "id" => $razorpayOrder['id'],
                        "entity" => $razorpayOrder['entity'],
                        "amount" => $razorpayOrder['amount'],
                        "amount_paid" => $razorpayOrder['amount_paid'],
                        "amount_due" => $razorpayOrder['amount_due'],
                        "currency" => $razorpayOrder['currency'],
                        "receipt" => $razorpayOrder['receipt'],
                        "offer_id" => $razorpayOrder['offer_id'],
                        "status" => $razorpayOrder['status'],
                        "attempts" => $razorpayOrder['attempts'],
                        "created_at" => $razorpayOrder['created_at']
                    ));

                    if ($orderDb->save($thisOrder)) {
                        // then return the response with success
                        $response['message'] = 'Order created succesfully.';
                        $response['success'] = true;
                        $response['data'] = array(
                            'response' => json_decode($thisOrder['gateway_order_response'], true),
                            'order' => $thisOrder
                        );
                    } else {
                        $response['message'] = 'Unable to create order on local gateway. please try after some time, or contact site administrator.';
                    }
                } else {
                    $thisOrder['gateway_order_response'] = json_encode($razorpayOrder);
                    $orderDb->save($thisOrder);
                    $response['message'] = 'Unable to create order on gateway. please try after some time, or contact site administrator.';
                }
            } catch (\Throwable $e) {
                $response['data'] = $e->getMessage();
            }
        }
        return $response;
    }
}
