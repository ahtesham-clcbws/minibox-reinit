<?php

// Create a new instance of our RouteCollection class.

use Config\Services;

$routes = Services::routes();


$routes->add('development/email/(:segment)', 'Services\Development::email/$1', ['as' => 'development_email']);
$routes->add('development/invoice/(:segment)', 'Services\Development::invoice/$1', ['as' => 'development_invoice']);
$routes->add('development/ticket/(:segment)', 'Services\Development::ticket/$1', ['as' => 'development_ticket']);