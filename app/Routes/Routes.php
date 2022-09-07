<?php

// Create a new instance of our RouteCollection class.

use Config\Services;

$routes = Services::routes();

// if (is_file(APPPATH . 'Routes/Routes.php')) {
//     require APPPATH . 'Routes/Routes.php';
// }

// admin only routes
$routes->group('admin', ['filter' => 'adminauth'], static function ($routes) {
    require APPPATH . 'Routes/admin.php';
});

// frontend film festival routes
$routes->group('film-festival', static function ($routes) {
    require APPPATH . 'Routes/film_festival.php';
});
// frontend events routes
$routes->group('event', static function ($routes) {
    require APPPATH . 'Routes/events.php';
});
// frontend film market routes
$routes->group('film-market', static function ($routes) {
    require APPPATH . 'Routes/film_market.php';
});
// frontend film zine routes
$routes->group('film-zine', static function ($routes) {
    require APPPATH . 'Routes/film_zine.php';
});
// frontend prime watch routes
$routes->group('prime-watch', static function ($routes) {
    require APPPATH . 'Routes/prime_watch.php';
});
// frontend prime kids routes
$routes->group('prime-kids', static function ($routes) {
    require APPPATH . 'Routes/prime_kids.php';
});
// frontend store routes
$routes->group('store', static function ($routes) {
    require APPPATH . 'Routes/store.php';
});

// route file should be last file.
require APPPATH . 'Routes/main.php';

$routes->group('auth', static function ($routes) {
    require APPPATH . 'Routes/auth.php';
});
