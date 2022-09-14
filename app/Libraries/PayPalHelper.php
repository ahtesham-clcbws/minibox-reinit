<?php

namespace App\Libraries;

use App\Models\Payment\OrderModel;
use stdClass;

/**
 *	PayPal helper class for REST API requests.
 *	
 */

class PayPalHelper
{

	private $_http = null;
	private $_apiUrl = null;
	private $_token = null;

	/**
	 * 	Class constructor.
	 *	
	 */
	public function __construct()
	{
		$this->_http = new PaypalHttpHelper;
		$this->_apiUrl = PAYPAL_ENDPOINTS[getenv('PAYPAL_ENV')];
	}

	/**
	 * 	Set PayPal default header for the curl instance.
	 *
	 * 	@return void
	 */
	private function _setDefaultHeaders()
	{
		$this->_http->addHeader("PayPal-Partner-Attribution-Id: " . SBN_CODE);
	}

	/**
	 * 	Create the PayPal REST endpoint url.
	 *
	 *	Use the configurations and combine resources to create the endpoint.
	 *
	 *	@param string $resource Url to be called using curl
	 * 	@return string REST API url depending on environment.
	 */
	private function _createApiUrl($resource)
	{
		if ($resource == 'oauth2/token')
			return $this->_apiUrl . "/v1/" . $resource;
		else
			return $this->_apiUrl . "/" . PAYPAL_REST_VERSION . "/" . $resource;
	}

	/**
	 * 	Request for PayPal REST oath bearer token.
	 *	
	 * 	Reset curl helper. 
	 *	Set default PayPal headers.
	 *	Set curl url.
	 *	Set curl credentials.
	 *	Set curl body.
	 *	Set class token attribute with bearer token.
	 *
	 * 	@return void
	 */
	private function _getToken()
	{
		$this->_http->resetHelper();
		$this->_setDefaultHeaders();
		$this->_http->setUrl($this->_createApiUrl("oauth2/token"));
		$this->_http->setAuthentication(PAYPAL_CREDENTIALS[getenv('PAYPAL_ENV')]['client_id'] . ":" . PAYPAL_CREDENTIALS[getenv('PAYPAL_ENV')]['client_secret']);
		$this->_http->setBody("grant_type=client_credentials");
		$returnData = $this->_http->sendRequest();
		$this->_token = $returnData['access_token'];
	}

	/**
	 * 	Actual call to curl helper to create an order using PayPal REST APIs.
	 *	
	 * 	Reset curl helper.
	 *	Set default PayPal headers.
	 * 	Set API call specific headers.
	 *	Set curl url.
	 *	Set curl body.
	 *
	 *	@param array $postData Url to be called using curl
	 * 	@return array PayPal REST create response
	 */
	private function _createOrder($postData)
	{
		$this->_http->resetHelper();
		$this->_setDefaultHeaders();
		$this->_http->addHeader("Content-Type: application/json");
		$this->_http->addHeader("Authorization: Bearer " . $this->_token);
		$this->_http->setUrl($this->_createApiUrl("checkout/orders"));
		$this->_http->setBody($postData);
		return $this->_http->sendRequest();
	}

	/**
	 * 	Actual call to curl helper to get a payment using PayPal REST APIs.
	 *
	 * 	Reset curl helper.
	 *	Set default PayPal headers.
	 * 	Set API call specific headers.
	 *	Set curl url.
	 *
	 * 	@param array $postData Url to be called using curl
	 * 	@return array PayPal REST execute response
	 */
	private function _getOrderDetails()
	{
		$this->_http->resetHelper();
		$this->_setDefaultHeaders();
		$this->_http->addHeader("Content-Type: application/json");
		$this->_http->addHeader("Authorization: Bearer " . $this->_token);
		$this->_http->setUrl($this->_createApiUrl("checkout/orders/" . $_SESSION['paypal_order_id']));
		return $this->_http->sendRequest();
	}

	/**
	 * 	Actual call to curl helper to execute a payment using PayPal REST APIs.
	 *	
	 * 	Reset curl helper.
	 *	Set default PayPal headers.
	 * 	Set API call specific headers.
	 *	Set curl url.
	 *	Set curl body.
	 *
	 *	@param array $postData Url to be called using curl
	 * 	@return array PayPal REST execute response
	 */
	private function _patchOrder($postData)
	{
		$this->_http->resetHelper();
		$this->_setDefaultHeaders();
		$this->_http->addHeader("Content-Type: application/json");
		$this->_http->addHeader("Authorization: Bearer " . $this->_token);
		$this->_http->setUrl($this->_createApiUrl("checkout/orders/" . $_SESSION['paypal_order_id']));
		$this->_http->setPatchBody($postData);
		return $this->_http->sendRequest();
	}

	/**
	 * 	Actual call to curl helper to capture an order using PayPal REST APIs.
	 *	
	 * 	Reset curl helper.
	 *	Set default PayPal headers.
	 * 	Set API call specific headers.
	 *	Set curl url.
	 *	Set curl body.
	 *
	 *	@param array $postData Url to be called using curl
	 * 	@return array PayPal REST capture response
	 */
	private function _captureOrder()
	{
		$this->_http->resetHelper();
		$this->_setDefaultHeaders();
		$this->_http->addHeader("Content-Type: application/json");
		$this->_http->addHeader("Authorization: Bearer " . $this->_token);
		$this->_http->setUrl($this->_createApiUrl("checkout/orders/" . $_SESSION['paypal_order_id'] . "/capture"));
		$postData = '{}';
		$this->_http->setBody($postData);
		//unset($_SESSION['paypal_order_id']);
		return $this->_http->sendRequest();
	}
	private function _paypalOrderObject($payload)
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
		$purchase_units->custom_id = $payload['custom_id'];
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
			$pInfo = (array) $pInfo;
			$item = new stdClass();
			if ($pInfo['type'] == 'ticket') {
				$name = 'Ticket';
				if ($pInfo['quantity'] > 1) {
					$name = 'Tickets';
				}
			} else {
				$name = $this->_descriptionLength($pInfo['name']);
			}
			$item->name = $name;
			if ($payload['type_of_action'] != 'festival_entry') {
				$item->description = $this->_descriptionLength($pInfo['details']);
			}
			$item->unit_amount = new stdClass();
			$item->unit_amount->currency_code = 'EUR';
			$item->unit_amount->value = isset($pInfo['amount']) ? $pInfo['amount'] : $pInfo['total'];
			$item->quantity = $pInfo['quantity'];
			$item->category = 'DIGITAL_GOODS';
			$purchase_units->items[] = (object) $item;
		}
		return json_encode($orderData);
	}
	private function _descriptionLength($description)
	{
		if (strlen($description) > 120) {
			$description = substr($description, 0, 120);
			$description = $description . '...';
		}
		return $description;
	}
	private function _localOrderSave($orderId, $returnData)
	{
		helper('common');
		$orderDb = new OrderModel();
		$thisOrder = $orderDb->find($orderId);
		$thisOrder['order_id'] = $returnData['id'];
		$thisOrder['gateway_order_response'] = json_encode($returnData);

		$orderDb->save($thisOrder);
	}

	/**
	 * 	Call private order create class function to forward curl request to helper.
	 *	
	 * 	Check for bearer token.
	 *	Call internal REST create order function.
	 *
	 *	@param array $postData Url to be called using curl
	 * 	@return array Formatted API response
	 */
	public function orderCreate($postData)
	{
		// $orderDb = new OrderModel();
		// $thisOrder = $orderDb->localOrderCreate($postData, 'paypal', 'EUR');
		$thisOrder = $this->_localOrderCreate($postData);
		if ($thisOrder) {
			$postData['custom_id'] = $thisOrder['id'];
			// $postData = json_encode($postData);
			// $postData = json_decode($postData, true);

			$paypalData = $this->_paypalOrderObject($postData);
			// return $paypalData;
			if ($this->_token === null) {
				$this->_getToken();
			}
			$returnData = $this->_createOrder($paypalData);
			if (isset($returnData['id'])) {
				$_SESSION['paypal_order_id'] = $returnData['id'];
				$this->_localOrderSave($thisOrder['id'], $returnData);

				return array(
					"ack" => true,
					"data" => $returnData,
					"loca_order" => $thisOrder
					// "data" => array(
					// 	"id" => $returnData['id']
					// )
				);
			}
			return $returnData;
		}
		return $thisOrder;
	}

	/**
	 * 	Call private payment get class function to forward curl request to helper.
	 *
	 * 	Check for bearer token.
	 *	Call internal REST get order details function.
	 *
	 *  @param array $postData Url to be called using curl
	 * 	@return array Formatted API response
	 */
	public function orderGet()
	{
		if ($this->_token === null) {
			$this->_getToken();
		}
		$returnData = $this->_getOrderDetails();
		return array(
			"ack" => true,
			"data" => $returnData
		);
	}

	/**
	 * 	Call private patch order class function to forward curl request to helper.
	 *	
	 * 	Check for bearer token.
	 *	Call internal REST patch order function.
	 *
	 *   @param array $postData Url to be called using curl
	 * 	@return array Formatted API response
	 */
	public function orderPatch($postData)
	{
		if ($this->_token === null) {
			$this->_getToken();
		}
		$returnData = $this->_patchOrder($postData);
		return array(
			"ack" => true,
			"data" => $returnData
		);
	}

	/**
	 * 	Call private capture order class function to forward curl request to helper.
	 *	
	 * 	Check for bearer token.
	 *	Call internal REST capture order function.
	 *
	 *   @param array $postData Url to be called using curl
	 * 	@return array Formatted API response
	 */
	public function orderCapture()
	{
		if ($this->_token === null) {
			$this->_getToken();
		}
		$returnData = $this->_captureOrder();
		//var_dump($returnData);
		return array(
			"ack" => true,
			"data" => $returnData
		);
	}

	private function _localOrderCreate($payload)
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
			'currency' => 'EUR',
			'gateway' => 'paypal',
		];

		$orderDb = new OrderModel();
		$orderSave = $orderDb->save($order);
		if ($orderSave) {
			return $orderDb->where('receipt', $payload['receipt'])->first();
		}
		return $orderSave;
	}
}
