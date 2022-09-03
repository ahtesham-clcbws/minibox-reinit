<?php

// use Config\Services;

// $routes = Services::routes();

$routes->add('register', 'AuthController::register',  ['as' => 'register']);
$routes->add('login', 'AuthController::login',  ['as' => 'login']);
$routes->add('forget', 'AuthController::forget',  ['as' => 'forget']);
$routes->add('recover', 'AuthController::recover',  ['as' => 'recover']);
$routes->add('logout', 'AuthController::logout',  ['as' => 'logout']);
