<?php

// Create a new instance of our RouteCollection class.

use Config\Services;

$routes = Services::routes();


$routes->get('/', 'Home::index', ['as' => 'homepage']);
$routes->get('about/miniboxoffice', 'Home::index', ['as' => 'about']);



$routes->add('common-internal-functions', 'CommonController::index', ['as' => 'commonFunctions']);
