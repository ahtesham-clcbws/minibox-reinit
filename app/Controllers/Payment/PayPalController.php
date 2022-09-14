<?php

namespace App\Controllers\Payment;

use App\Libraries\PayPalHelper;
use App\Models\Events\EventTicketRegistration;
use App\Models\Festival\FestivalDelegates;
use App\Models\Festival\FestivalEntries;
use App\Models\Payment\OrderModel;
use App\Models\ServiceModels\EmailsModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

class PayPalController extends Controller
{
    use ResponseTrait;
    public function createOrder()
    {
        $payload = $this->request->getPost();
        // $response = ['success' => false, 'message' => 'Unable to create order (PFO). please try after some time, or contact site administrator.', 'data' => []];
        $thisOrder = $this->localOrderCreate($payload, 'paypal', 'EUR');

        $payload['custom_id'] = $thisOrder['id'];
        // $response = ['success' => false, 'message' => 'Unable to create order (PFI). please try after some time, or contact site administrator.', 'data' => []];

        $orderData = $this->paypalOrderObject($payload);
        $paypalHelper = new PayPalHelper;

        return $this->setResponseFormat('json')->respond(['error' => false]);

        // $response = ['success' => false, 'message' => 'Unable to create order (PFU). please try after some time, or contact site administrator.', 'data' => []];

        // $orderCreate = json_encode($paypalHelper->orderCreate(json_encode($orderData)));
        return json_encode($paypalHelper->orderCreate(json_encode($orderData)));

        // if ($thisOrder) {
        //     // then create order on paypal
        //     // paypal order creation starts here

        //     // return $razorpayOrderData;
        //     try {
        //         $paypalHelper = new PayPalHelper;
        //         $orderCreate = $paypalHelper->orderCreate(json_encode($orderData));

        //         // $response['data'] = $razorpayOrder['id'];
        //         return $orderCreate;

        //         if (isset($orderCreate['ack']) && $orderCreate['ack'] == true) {
        //             // then ammend local order values
        //             $thisOrder['order_id'] = $orderCreate['data']['id'];
        //             $thisOrder['gateway_order_response'] = json_encode($orderCreate['all_data']);

        //             if ($this->save($thisOrder)) {
        //                 // then return the response with success
        //                 return $orderCreate;
        //                 $response['ack'] = true;
        //                 $response['message'] = 'Order created succesfully.';
        //                 $response['success'] = true;
        //                 $response['data'] = array(
        //                     'response' => json_decode($thisOrder['gateway_order_response'], true),
        //                     'order' => $thisOrder
        //                 );
        //                 $response['data']['id'] = $orderCreate['data']['id'];
        //             } else {
        //                 $response['message'] = 'Unable to create order on local gateway. please try after some time, or contact site administrator.';
        //             }
        //         } else {
        //             $thisOrder['gateway_order_response'] = json_encode($orderCreate);
        //             $this->save($thisOrder);
        //             $response['message'] = 'Unable to create order on gateway. please try after some time, or contact site administrator.';
        //         }
        //     } catch (\Throwable $e) {
        //         $response['data'] = $e->getMessage();
        //     }
        // }
        // return $response;
    }
    public function paypalOrderGet()
    {
        $paypalHelper = new PayPalHelper;

        // header('Content-Type: application/json');
        return json_encode($paypalHelper->orderGet());
    }
    public function paypalPaymentSave()
    {
        helper('common');
        $paymentSuccessMessage = 'Payment Successfull. Please check your email further instructions. if you don\'t receive email or getting errors receiving email, please contact us at ' . CUSTOMER_SUPPORT_EMAIL . ' With your bank transaction slip or screenshot.';

        $requestData = $this->request->getPost();
        $response = ['success' => false, 'message' => 'There is some errors in your paypal payment, if you already done the payment. Please contact us with full payment details.', 'data' => []];
        if (isset($requestData['status']) && $requestData['status'] == 'APPROVED') {


            $orderDb = new OrderModel();
            $thisOrder = $orderDb->where('order_id', $requestData['id'])->first();

            $response = ['success' => false, 'message' => 'Unable to find your order. But your payment is success, Please contact us with full payment details.', 'data' => []];
            if ($thisOrder) {
                $thisOrder['payment_status'] = 'completed';
                $thisOrder['gateway_response'] = json_encode($requestData);
                $thisOrder['order_created_date'] = $requestData['create_time'];

                // $rData = json_decode($requestData);
                $rData = $requestData;

                if (isset($rData['purchase_units']) && $rData = $rData['purchase_units']) {
                    if (isset($rData[0], $rData[0]['shipping']) && $rData = $rData[0]['shipping']) {
                        if (isset($rData['address']) && $rData = $rData['address']) {
                            if (empty($thisOrder['user_address'])) {
                                $thisOrder['user_address'] =  isset($rData['address_line_1']) ? $rData['address_line_1'] . ',' . $rData['address_line_2'] : NULL;
                            }
                        }
                    }
                }

                if ($thisOrder['type_of_action'] == 'delegate_registration') {
                    $delegateDb = new FestivalDelegates();
                    $thisDelegate = $delegateDb->where('receipt', $thisOrder['receipt'])->first();
                    if ($thisDelegate) {
                        $delegateDetails['id'] = $thisDelegate['id'];
                        $delegateDetails['order_id'] = $thisOrder['id'];
                        $delegateDetails['gateway_order_id'] = $thisOrder['order_id'];
                        $delegateDetails['payment_status'] = 'completed';
                        $delegateDb->save($delegateDetails);
                    }
                    $emailModel = new EmailsModel();
                    $emailModel->sendOrderEmail($thisOrder, ['delegate', 'ticket']);
                }
                if ($thisOrder['type_of_action'] == 'festival_entry') {
                    $festivalEntriesDb = new FestivalEntries();
                    $thisEntry = $festivalEntriesDb->where('receipt', $thisOrder['receipt'])->first();
                    if ($thisEntry) {
                        $entryDetails['id'] = $thisEntry['id'];
                        $entryDetails['order_id'] = $thisOrder['id'];
                        $entryDetails['gateway_order_id'] = $thisOrder['order_id'];
                        $entryDetails['payment_status'] = 'completed';
                        $festivalEntriesDb->save($entryDetails);
                    }
                    $emailModel = new EmailsModel();
                    $emailModel->sendOrderEmail($thisOrder, ['festival', 'entry']);
                }
                if ($thisOrder['type_of_action'] == 'event_ticket') {

                    $eventTicketDb = new EventTicketRegistration();

                    $thisTicket = $eventTicketDb->where('receipt', $thisOrder['receipt'])->first();
                    if ($thisTicket) {
                        $ticketDetails['id'] = $thisTicket['id'];
                        $ticketDetails['order_id'] = $thisOrder['id'];
                        $ticketDetails['gateway_order_id'] = $thisOrder['order_id'];
                        $ticketDetails['payment_status'] = 'completed';
                        $eventTicketDb->save($ticketDetails);
                    }
                    $emailModel = new EmailsModel();
                    $emailModel->sendOrderEmail($thisOrder, ['festival', 'entry']);
                }
                if ($orderDb->save($thisOrder)) {
                    $response = ['success' => true, 'message' => $paymentSuccessMessage, 'data' => $thisOrder];
                } else {
                    $response = ['success' => false, 'message' => 'Some errors occur on the portal. Please contact us with full payment details', 'data' => []];
                }
            }
        }
        return json_encode($response);
    }
}
