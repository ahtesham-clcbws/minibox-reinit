<?php

namespace App\Models\Payment;

use App\Libraries\PayPalHelper;
use CodeIgniter\Model;
use Razorpay\Api\Api;
use stdClass;

class OrderModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'local_orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_name',
        'user_email',
        'user_phone',
        'other_user_info', // name, email, firstname, lastname, address, country, postalcode, currency
        'currency',
        'payment_status', // 'failed','pending','completed','cancelled'
        'gateway_response',
        'gateway_order_response',
        'order_created_date',
        'coupon_id',
        'discount_value',
        'discount_description',
        'discount_type',
        'gateway', // 'razorpay','paypal','stripe' 
        'order_id',
        'receipt',
        'payment_id',
        'amount',
        'signature',
        'other_gateway_json',
        'product_information',
        'product_name',
        'type_of_action',
        'user_address',
        'user_pincode',
        'user_city',
        'user_state',
        'user_country',
        'order_items',
        'tax_gst'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function razorpayCreateOrder($payload)
    {
        $response = ['success' => false, 'message' => 'Unable to create order. please try after some time, or contact site administrator.', 'data' => []];
        $thisOrder = $this->localOrderCreate($payload, 'razorpay', 'INR');
        if ($thisOrder) {
            // $thisOrder = $this->where('receipt', $payload['receipt'])->first();
            // then create order on razorpay
            $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_SECRET);

            $product_information = json_decode($thisOrder['product_information'], true);
            // if ($thisOrder['type_of_action'] == 'festival_entry') {
            //     $product_information = NULL;
            // }

            foreach ($product_information as $key => $pInf) {
                if ($pInf['details']) {
                    unset($pInf['details']);
                    $product_information[$key] = $pInf;
                }
            }
            $product_information = json_encode($product_information);

            if (strlen($product_information) > 250) {
                $product_information = 'Product information exceeds the maximum length.';
            }

            $razorpayOrderData = array(
                'receipt' => $thisOrder['receipt'],
                'amount' => intval($thisOrder['amount']) * 100,
                'currency' => 'INR',
                'notes' => array('info' => $product_information),
            );
            // return $product_information;
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

                    if ($this->save($thisOrder)) {
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
                    $this->save($thisOrder);
                    $response['message'] = 'Unable to create order on gateway. please try after some time, or contact site administrator.';
                }
            } catch (\Throwable $e) {
                $response['data'] = $e->getMessage();
            }
        }
        return $response;
    }
    public function localOrderCreate($payload, $gateway, $currency)
    {
        $order = [
            'amount' => $payload['amount'],
            'product_information' => json_encode($payload['product_information']),
            'product_name' => $payload['product_name'],
            'user_name' => $payload['user_name'],
            'user_email' => $payload['user_email'],
            'user_phone' => $payload['user_phone'],
            'other_user_info' => json_encode($payload['other_user_info']),
            'receipt' => $payload['receipt'],
            'type_of_action' => $payload['type_of_action'],
            'user_address' =>  isset($payload['user_address']) ? $payload['user_address'] : NULL,
            'user_pincode' => isset($payload['user_pincode']) ? $payload['user_pincode'] : NULL,
            'user_city' => isset($payload['user_city']) ? $payload['user_city'] : NULL,
            'user_state' => isset($payload['user_state']) ? $payload['user_state'] : NULL,
            'user_country' => isset($payload['user_country']) ? $payload['user_country'] : NULL,
            'order_items' => $payload['order_items'],
            'currency' => $currency,
            'gateway' => $gateway,
            'payment_status' => 'processing'
        ];
        if ($currency == 'INR') {
            $order['tax_gst'] = $payload['tax_gst'];
        }
        if ($this->save($order)) {
            return $this->where('receipt', $payload['receipt'])->first();
        }
        return false;
    }

    // deprecated
    public function paypalCreateOrder($payload)
    {
        $response = ['success' => false, 'message' => 'Unable to create order (PFO). please try after some time, or contact site administrator.', 'data' => []];
        $thisOrder = $this->localOrderCreate($payload, 'paypal', 'EUR');

        $payload['custom_id'] = $thisOrder['id'];
        // $response = ['success' => false, 'message' => 'Unable to create order (PFI). please try after some time, or contact site administrator.', 'data' => []];

        $orderData = $this->paypalOrderObject($payload);
        $paypalHelper = new PayPalHelper;

        // $response = ['success' => false, 'message' => 'Unable to create order (PFU). please try after some time, or contact site administrator.', 'data' => []];

        // $orderCreate = json_encode($paypalHelper->orderCreate(json_encode($orderData)));
        return json_encode($paypalHelper->orderCreate(json_encode($orderData)));

        if ($thisOrder) {
            // then create order on paypal
            // paypal order creation starts here

            // return $razorpayOrderData;
            try {
                $paypalHelper = new PayPalHelper;
                $orderCreate = $paypalHelper->orderCreate(json_encode($orderData));

                // $response['data'] = $razorpayOrder['id'];
                return $orderCreate;

                if (isset($orderCreate['ack']) && $orderCreate['ack'] == true) {
                    // then ammend local order values
                    $thisOrder['order_id'] = $orderCreate['data']['id'];
                    $thisOrder['gateway_order_response'] = json_encode($orderCreate['all_data']);

                    if ($this->save($thisOrder)) {
                        // then return the response with success
                        return $orderCreate;
                        $response['ack'] = true;
                        $response['message'] = 'Order created succesfully.';
                        $response['success'] = true;
                        $response['data'] = array(
                            'response' => json_decode($thisOrder['gateway_order_response'], true),
                            'order' => $thisOrder
                        );
                        $response['data']['id'] = $orderCreate['data']['id'];
                    } else {
                        $response['message'] = 'Unable to create order on local gateway. please try after some time, or contact site administrator.';
                    }
                } else {
                    $thisOrder['gateway_order_response'] = json_encode($orderCreate);
                    $this->save($thisOrder);
                    $response['message'] = 'Unable to create order on gateway. please try after some time, or contact site administrator.';
                }
            } catch (\Throwable $e) {
                $response['data'] = $e->getMessage();
            }
        }
        return $response;
    }
    public function paypalOrderObject($payload)
    {
        $orderData = new stdClass();
        $orderData->intent = 'CAPTURE';
        $orderData->application_context = new stdClass();
        $orderData->application_context->return_url = '';
        $orderData->application_context->cancel_url = '';
        $purchase_units = new stdClass();
        $purchase_units->reference_id = $payload['receipt'];
        $purchase_units->description = $payload['product_name'];
        $purchase_units->invoice_id = $payload['receipt'];
        // $purchase_units->custom_id = $payload['custom_id'];
        $purchase_units->amount = new stdClass();
        $purchase_units->amount->currency_code = 'EUR';
        $purchase_units->amount->value = $payload['amount'];
        $purchase_units->amount->breakdown = new stdClass();
        $purchase_units->amount->breakdown->item_total = new stdClass();
        $purchase_units->amount->breakdown->item_total->currency_code = 'EUR';
        $purchase_units->amount->breakdown->item_total->value = $payload['amount'];

        $orderData->purchase_units = array($purchase_units);

        $purchase_units->items = array();
        foreach ($payload['product_information'] as $key => $pInfo) {
            $item = new stdClass();
            $item->name = $pInfo['type'] == 'ticket' ? 'Ticket' : $pInfo['name'];
            $item->description = $pInfo['details'];
            $item->sku = $pInfo['id'];
            $item->unit_amount = new stdClass();
            $item->unit_amount->currency_code = 'EUR';
            $item->unit_amount->value = $pInfo['amount'];
            $item->quantity = $pInfo['quantity'];
            $purchase_units->items[$key] = $item;
        }
        return json_encode($orderData);
    }
}
