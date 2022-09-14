<?php

// Create a new instance of our RouteCollection class.

use Config\Services;

$routes = Services::routes();

$routes->add('all', 'Web\EventsController::index',  ['as' => 'events']);
$routes->add('details/(:any)', 'Web\EventsController::single/$1',  ['as' => 'event_details']);


// internal post request for event registration
$routes->post('event-registration', 'Web\EventsController::eventRegistration',  ['as' => 'event_tickets_registration']);