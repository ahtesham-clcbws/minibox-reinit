<?php

// Create a new instance of our RouteCollection class.

use Config\Services;

$routes = Services::routes();

$routes->group('(:segment)', [Web\FilmFestival::class], static function ($routes) {
    $routes->add('/', 'Web\FilmFestival::festival_details',  ['as' => 'festival_details']);

    // about menu
    $routes->add('about', 'Web\FilmFestival::festival_about',  ['as' => 'festival_about']);
    $routes->add('team', 'Web\FilmFestival::festival_team',  ['as' => 'festival_team']);
    $routes->add('sponsorship-and-promotion', 'Web\FilmFestival::festival_sponsorship',  ['as' => 'festival_sponsorship']);
    $routes->add('volunteer', 'Web\FilmFestival::festival_volunteer',  ['as' => 'festival_volunteer']);
    $routes->add('venue', 'Web\FilmFestival::festival_venue',  ['as' => 'festival_venue']);
    $routes->add('schedule', 'Web\FilmFestival::festival_schedule',  ['as' => 'festival_schedule']);
    $routes->add('delegate-registration', 'Web\FilmFestival::festival_delegate_registration',  ['as' => 'festival_delegate_registration']);
    $routes->add('support', 'Web\FilmFestival::festival_support',  ['as' => 'festival_support']);

    // main menu
    $routes->add('winners', 'Web\FilmFestival::festival_winners',  ['as' => 'festival_winners']);
    $routes->add('official-selections', 'Web\FilmFestival::festival_official_selection',  ['as' => 'festival_official_selection']);
    $routes->add('juries', 'Web\FilmFestival::festival_jury',  ['as' => 'festival_jury']);
    $routes->add('press', 'Web\FilmFestival::festival_press',  ['as' => 'festival_press']);
    $routes->add('gallery', 'Web\FilmFestival::festival_gallery',  ['as' => 'festival_gallery']);
    $routes->add('awards', 'Web\FilmFestival::festival_awards',  ['as' => 'festival_awards']);
    $routes->add('entry-form', 'Web\FilmFestival::festival_entry_form',  ['as' => 'festival_entry_form']);
    // $routes->add('jury/(:any)', 'Web\FilmFestival::festival_jury_single/$1/$2',  ['as' => 'festival_jury_details']);
    $routes->add('events', 'Web\FilmFestival::festival_events',  ['as' => 'festival_events']);
});
// media
$routes->add('(:any)/entry-form/(:any)', 'Web\FilmFestival::festival_entry_form_extended/$1/$2',  ['as' => 'festival_entry_form_extended']);
$routes->add('(:segment)/official-selections/(:segment)', 'Web\FilmFestival::festival_official_selection_details/$1/$2',  ['as' => 'festival_official_selection_details']);
$routes->add('(:segment)/media/(:any)/(:any)', 'Web\FilmFestival::festival_media_single/$1/$2/$3',  ['as' => 'festival_filmzine_media_single']);
$routes->add('(:segment)/media/(:any)', 'Web\FilmFestival::festival_media/$1/$2',  ['as' => 'festival_filmzine_media']);

$routes->add('(:segment)/event-details/(:any)', 'Web\FilmFestival::festival_event_details/$1/$2',  ['as' => 'festival_event_details']);

$routes->add('(:segment)/jury/(:any)', 'Web\FilmFestival::festival_jury_single/$1/$2',  ['as' => 'festival_jury_details']);

$routes->add('/', 'Web\FilmFestival::index',  ['as' => 'festival_index']);

// $routes->add('(:segment)', 'Web\FilmFestival::index/$1',  ['as' => 'festival_details']);

// $routes->add('(:segment)/about', 'Web\FilmFestival::festival_about/$1',  ['as' => 'festival_about']);
// $routes->add('(:segment)/team', 'Web\FilmFestival::index/$1',  ['as' => 'festival_team']);
// $routes->add('(:segment)/sponsorship-and-promotion', 'Web\FilmFestival::index/$1',  ['as' => 'festival_sponsorship']);
// $routes->add('(:segment)/volunteer', 'Web\FilmFestival::index/$1',  ['as' => 'festival_volunteer']);
// $routes->add('(:segment)/venue', 'Web\FilmFestival::index/$1',  ['as' => 'festival_venue']);
// $routes->add('(:segment)/schedule', 'Web\FilmFestival::index/$1',  ['as' => 'festival_schedule']);
// $routes->add('(:segment)/delegate-registration', 'Web\FilmFestival::index/$1',  ['as' => 'festival_delegate_registration']);
// $routes->add('(:segment)/support', 'Web\FilmFestival::index/$1',  ['as' => 'festival_support']);