<?php

namespace App\Controllers\Payment;

use App\Controllers\BaseController;
use App\Models\Events\EventTicketRegistration;
use App\Models\Festival\FestivalDelegates;
use App\Models\Festival\FestivalEntries;
use App\Models\Payment\OrderModel;
use App\Models\ServiceModels\EmailsModel;
// require('razorpay-php/Razorpay.php');
// require 'razorpay/razorpay/Razorpay.php';
use Razorpay\Api\Api as RazorpayApi;

class PaymentController extends BaseController
{
    protected $session;
    public function __construct()
    {
        $this->session = session();
        $this->data['pageName'] = 'Checkout';
        $this->data['pageTitle'] = 'Checkout | Mini Box Office';
    }
    public function index()
    {
        $country = getUserCountry();
        $this->data['country'] = $country;
        if ($this->request->getPost()) {

            if ($country == 'IN') {
                $this->data['currency_code'] = 'INR';
                $this->data['currency'] = 'inr';
                $this->data['currency_symbol'] = 'inr';
            } else {
                $this->data['currency_code'] = 'EUR';
            }

            $requestData = $this->request->getPost();
            if ($requestData['createOrder']) {
                $productUrl = $this->request->getPost('url');

                $product_information = $requestData['productDetails'];
                $user_info = $requestData['user_info'];
                // formdata
                $orderData = array(
                    'gateway' => $requestData['gateway'], // razorpay, paypal, stripe
                    'product_information' => $product_information,
                    'user_info' => $user_info, // name, email, firstname, lastname, address, country, postalcode, currency
                    'amount' => $requestData['payable_amount'],
                    'currency' => $this->data['currency_code'],
                    'receipt' => uniqidReal()
                );
                // return print_r($orderData);
                // create order to server

                // create order to gateway server
                if ($requestData['gateway'] == 'razorpay') {
                    $api = new RazorpayApi(RAZORPAY_KEY_ID, RAZORPAY_SECRET);
                    // return print_r($api);
                    $razorpayOrderData = [
                        'receipt'         => $orderData['receipt'],
                        'amount'          => $orderData['amount'] * 100, // 39900 rupees in paise
                        'currency'        => 'INR',
                        'notes'           => $orderData['product_information'],
                    ];
                    // return print_r($razorpayOrderData);
                    $razorpayOrder = $api->order->create($razorpayOrderData);

                    if (isset($razorpayOrder['id']) && $razorpayOrder['status'] == 'created') {
                    }
                    return print_r($razorpayOrder);
                }
            }
            return print_r($this->data);

            // return view("checkout", $this->data);
        } else {
            session()->set('paymentError', 'Your request is not valid.');
            return redirect()->back();
        }
    }

    public function paymentSuccess()
    {
        $paymentSuccessMessage = 'Payment Successfull. Please check your email further instructions. if you don\'t receive email or getting errors receiving email, please contact us at ' . CUSTOMER_SUPPORT_EMAIL . ' With your bank transaction slip or screenshot.';
        $response = ['success' => false, 'message' => '', 'data' => ''];
        $response['message'] = 'No payment methods found.';
        $requestData = $this->request->getPost();
        $orderDb = new OrderModel();
        if (isset($requestData['gateway']) && $requestData['gateway'] == 'razorpay') {
            // first check payment status from razorpay
            // then verify signature
            // then verify orderdata
            // then send a success mail to user & reload the page;
            $thisOrder = $orderDb->where('order_id', $requestData['razorpay_order_id'])->first();
            $response['message'] = 'Order Not Found. please contact site staff with transaction ID.';
            if ($thisOrder) {
                $thisOrder['payment_id'] = $requestData['razorpay_payment_id'];
                $thisOrder['signature'] = $requestData['razorpay_signature'];
                $thisOrder['payment_status'] = 'completed';
                $response['message'] = $paymentSuccessMessage;
                $response['success'] = true;
                $orderDb->save($thisOrder);
                if ($thisOrder['type_of_action'] == 'deletegate_registration') {
                    $delegateRegsitrationDb = new FestivalDelegates();
                    $thisDelegate = $delegateRegsitrationDb->where(['gateway_order_id' => $requestData['razorpay_order_id']])->first();

                    $delegateDetails['id'] = $thisDelegate['id'];
                    $delegateDetails['payment_status'] = 'completed';
                    $delegateRegsitrationDb->save($delegateDetails);
                    // send email with tickets to user
                    $emailModel = new EmailsModel();
                    $emailModel->sendOrderEmail($thisOrder, ['delegate', 'ticket']);
                }
                if ($thisOrder['type_of_action'] == 'festival_entry') {
                    $festivalEntriesDb = new FestivalEntries();
                    $thisEntry = $festivalEntriesDb->where(['gateway_order_id' => $requestData['razorpay_order_id']])->first();
                    if ($thisEntry) {
                        $entryDetails['id'] = $thisEntry['id'];
                        $entryDetails['payment_status'] = 'completed';
                        $festivalEntriesDb->save($entryDetails);
                    }
                    $emailModel = new EmailsModel();
                    $emailModel->sendOrderEmail($thisOrder, ['festival', 'entry']);
                }
                if ($thisOrder['type_of_action'] == 'event_ticket') {
                    $eventTicketDb = new EventTicketRegistration();
                    $thisTicket = $eventTicketDb->where(['gateway_order_id' => $requestData['razorpay_order_id']])->first();

                    $ticketDetails['id'] = $thisTicket['id'];
                    $ticketDetails['payment_status'] = 'completed';
                    $eventTicketDb->save($ticketDetails);
                    // send email with tickets to user
                    $emailModel = new EmailsModel();
                    $emailModel->sendOrderEmail($thisOrder, ['event', 'ticket']);
                }
            }
        }
        return json_encode($response);
    }

    public function gatewayCallback($payload,  $gateway = 'razorpay', $productUrl = '')
    {
        $response = ['success' => false, 'message' => '', 'data' => ''];
        if ($gateway == 'razorpay') {
            if (!empty($payload['razorpay_payment_id']) && !empty($payload['merchant_order_id'])) {
                $razorpay_payment_id    = $payload['razorpay_payment_id'];
                $merchant_order_id      = $payload['merchant_order_id'];
                $this->session->set('razorpay_payment_id', $payload['razorpay_payment_id']);
                $this->session->set('merchant_order_id', $merchant_order_id);
                $currency_code = 'INR';
                $amount = $payload['merchant_total'];
                $success = false;
                $error = '';
                try {
                    $ch = $this->curl_handler($razorpay_payment_id, $amount);
                    //execute post
                    $result = curl_exec($ch);
                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if ($result === false) {
                        $success = false;
                        $error = 'Curl error: ' . curl_error($ch);
                    } else {
                        $response_array = json_decode($result, true);
                        //Check success response
                        if ($http_status === 200 and isset($response_array['error']) === false) {
                            $success = true;
                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'] . ':' . $response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>' . $result;
                            }
                        }
                    }
                    //close curl connection
                    curl_close($ch);
                } catch (\Exception $e) {
                    $success = false;
                    $error = 'Request to Razorpay Failed';
                }
                $response['success'] = $success;
                if (!$success) {
                    $response['message'] = 'Payment failed, please try after some time.';
                }
            } else {
                $response['message'] = 'An error occured. Contact site administrator, please!';
            }
            return $response;
        }
        if ($gateway == 'paypal') {
        }
        if ($gateway == 'stripe') {
        }
    }

    // unable to use now
    public function razorpayCallback()
    {
        // return json_encode($this->request->getPost());
        $response = ['success' => false, 'message' => '', 'data' => ''];

        if (!empty($this->request->getPost('razorpay_payment_id')) && !empty($this->request->getPost('razorpay_order_id'))) {

            $razorpay_payment_id     = $this->request->getPost('razorpay_payment_id');
            $orderDb = new OrderModel();
            $thisOrder = $orderDb->where('order_id', $this->request->getPost('razorpay_order_id'))->first();
            $response['message'] = 'Order Not Found. please contact site staff with transaction ID.';
            if ($thisOrder) {
                $thisOrder['payment_id'] = $razorpay_payment_id;
                $thisOrder['signature'] = $this->request->getPost('razorpay_signature');
                $thisOrder['payment_status'] = 'failed';

                $amount = intval($thisOrder['amount']) * 100;

                $success = false;
                $error = '';
                try {
                    $ch = $this->curl_handler($razorpay_payment_id, $amount);
                    //execute post
                    $result = curl_exec($ch);
                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if ($result === false) {
                        $success = false;
                        $error = 'Curl error: ' . curl_error($ch);
                    } else {
                        $response_array = json_decode($result, true);
                        //Check success response
                        if ($http_status === 200 and isset($response_array['error']) === false) {
                            $success = true;
                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'] . ':' . $response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>' . $result;
                            }
                        }
                    }
                    $response['message'] = $error;
                    //close curl connection
                    curl_close($ch);
                } catch (\Exception $e) {
                    $success = false;
                    $error = $e->getMessage();
                }

                $response['success'] = $success;
                if (!$success) {
                    // $response['message'] = 'Payment failed, please try after some time.';
                    $response['message'] = $error;
                } else {
                    $thisOrder['payment_status'] = 'completed';
                    $response['message'] = 'Payment Successfull.';
                    $response['success'] = true;
                }
                $orderDb->save($thisOrder);
            }
        } else {
            $response['message'] = 'An error occured. Contact site administrator, please!';
        }
        return json_encode($response);
        // $this->session->set('paymentStatus', $response['success']);
        // $this->session->set('paymentStatus', $response);
    }
}
