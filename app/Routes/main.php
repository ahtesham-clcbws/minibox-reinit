<?php

// Create a new instance of our RouteCollection class.

use Config\Services;

$routes = Services::routes();


$routes->get('/', 'Home::index', ['as' => 'homepage']);
$routes->get('about/miniboxoffice', 'Home::index', ['as' => 'about']);


// payment gateway routes
$routes->post('payment', 'Payment\PaymentController::index', ['as' => 'gatewayCallbak']);
$routes->post('payment/failed', 'Payment\PaymentController::gatewayFailed', ['as' => 'gatewayFailed']);
$routes->post('payment/success', 'Payment\PaymentController::paymentSuccess', ['as' => 'paymentSuccess']);

$routes->post('payment/razorpay', 'Payment\PaymentController::razorpayCallback', ['as' => 'razorpayCallback']);

$routes->add('common-internal-functions', 'CommonController::index', ['as' => 'commonFunctions']);
