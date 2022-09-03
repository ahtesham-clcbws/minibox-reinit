<?php

// Create a new instance of our RouteCollection class.

use Config\Services;

$routes = Services::routes();

$routes->get('/', 'Web\PrimeWatch::kids',  ['as' => 'prime_kids']);