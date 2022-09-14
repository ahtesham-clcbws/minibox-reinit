<?php

// Create a new instance of our RouteCollection class.

use Config\Services;

$routes = Services::routes();


$routes->add('online/view/(:segment)', 'Services\Emails::emailView/$1', ['as' => 'online_email_view']); // base64id of the email
// $routes->add('online/view/(:segment)', 'Services\Emails::email/$1', ['as' => 'development_email']); // base64id of the email

$routes->add('online/backup', 'Services\Emails::backup', ['as' => 'backup_email']); // base64id of the email

$routes->add('ppl-order', 'Payment\PayPalController::paypalOrderGet', ['as' => 'paypal_order_get']); // base64id of the email
$routes->post('ppl-save', 'Payment\PayPalController::paypalPaymentSave', ['as' => 'paypal_payment_save']); // base64id of the email