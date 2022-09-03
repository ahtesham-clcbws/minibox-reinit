<?php

// Create a new instance of our RouteCollection class.

use Config\Services;

$routes = Services::routes();

$routes->get('/', 'Web\FilmZine::index',  ['as' => 'film_zine']);

$routes->get('article/(:segment)', 'Web\FilmZine::details\$1',  ['as' => 'film_zine_article']); // slug to the segment