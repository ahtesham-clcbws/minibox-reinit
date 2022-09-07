<?php

// Create a new instance of our RouteCollection class.

use Config\Services;

$routes = Services::routes();

$routes->add('/', 'Admin\GlobalController::index', ['as' => 'admin_dashboard']);

$routes->group('film-festivals', static function ($routes) {
    $routes->add('/', 'Admin\FilmFestivalController::index', ['as' => 'admin_film_festivals']);
    // $routes->post('/', 'Admin\FilmFestivalController::saveFestivalData', ['as' => 'admin_film_festivals_add']);

    // very last
    $routes->group('/', static function ($routes) {

        $routes->add('(:num)', 'Admin\FilmFestivalController::festivalDetails/$1', ['as' => 'admin_festival_details']);

        $routes->add('info/(:num)/(:num)', 'Admin\FilmFestivalController::festivalDetailsInfo/$1/$2', ['as' => 'admin_festival_details_info']);
        // pdf route
        // $routes->add('info/(:num)/(:num)/pdf/(:any)', 'Admin\FilmFestivalController::festivalDetailsInfo/$1/$2', ['as' => 'admin_festival_details_info_view_pdf']);

        // pages only
        $routes->add('about/(:num)', 'Admin\FilmFestivalController::festivalAbout/$1', ['as' => 'admin_festival_details_about']);
        $routes->add('sponsorship-promotion/(:num)', 'Admin\FilmFestivalController::festivalSponsorshipPromotion/$1', ['as' => 'admin_festival_details_sponsorship']);
        $routes->add('awards/(:num)', 'Admin\FilmFestivalController::festivalAwards/$1', ['as' => 'admin_festival_details_awards']);
        $routes->add('schedules/(:num)', 'Admin\FilmFestivalController::festivalShedules/$1', ['as' => 'admin_festival_details_schedules']);
        $routes->add('venues/(:num)', 'Admin\FilmFestivalController::festivalVenues/$1', ['as' => 'admin_festival_details_venues']);

        $routes->add('pages-data/(:num)', 'Admin\FilmFestivalController::dynamicPagesHeaders/$1', ['as' => 'admin_festival_details_pages_data']);

        $routes->add('delegates/(:num)', 'Admin\FilmFestivalController::festivalDelegate/$1', ['as' => 'admin_festival_details_delegates']);
        $routes->add('delegate-packages/(:num)', 'Admin\FilmFestivalController::festivalDelegatePackages/$1', ['as' => 'admin_festival_details_delegate_packages']);

        $routes->add('volunteers/(:num)', 'Admin\FilmFestivalController::festivalVolunteers/$1', ['as' => 'admin_festival_details_volunteer']);
        $routes->add('movie-submitions/(:num)', 'Admin\FilmFestivalController::festivalSubmitions/$1', ['as' => 'admin_festival_details_submitions']);
        $routes->add('official-selection/(:num)', 'Admin\FilmFestivalController::festivalSelections/$1', ['as' => 'admin_festival_details_selection']);
        $routes->add('winners/(:num)', 'Admin\FilmFestivalController::festivalWinners/$1', ['as' => 'admin_festival_details_winners']);

        // $routes->add('applied-awards/(:num)', 'Admin\FilmFestivalController::festivalAwardsApplied/$1', ['as' => 'admin_festival_details_awards_applied']);
        $routes->add('events/(:num)', 'Admin\FilmFestivalController::festivalEvents/$1', ['as' => 'admin_festival_details_events']);
        $routes->add('team/(:num)', 'Admin\FilmFestivalController::festivalTeam/$1', ['as' => 'admin_festival_details_team']);

        $routes->add('jury/(:num)', 'Admin\FilmFestivalController::festivalJuries/$1', ['as' => 'admin_festival_details_jury']);
        $routes->add('gallery/(:num)', 'Admin\FilmFestivalController::festivalGallery/$1', ['as' => 'admin_festival_details_gallery']);
        $routes->add('banners/(:num)', 'Admin\FilmFestivalController::festivalBanners/$1', ['as' => 'admin_festival_details_banners']);
        $routes->add('press/(:num)', 'Admin\FilmFestivalController::festivalPress/$1', ['as' => 'admin_festival_details_press']);

        $routes->add('support-submission/(:num)', 'Admin\FilmFestivalController::festivalSupport/$1', ['as' => 'admin_festival_details_support']);

        $routes->add('filmzine/(:num)', 'Admin\FilmFestivalController::festivalFilmzine/$1', ['as' => 'admin_festival_details_filmzine']);
    });
});
$routes->group('film-market', static function ($routes) {
    $routes->add('/', 'Admin\FilmMarketController::index', ['as' => 'admin_film_market']);
});

$routes->group('events', static function ($routes) {
    $routes->add('/', 'Admin\EventsController::index', ['as' => 'admin_events']);
    $routes->group('/', static function ($routes) {
        $routes->add('categories', 'Admin\EventsController::categories', ['as' => 'admin_event_categories']);
        $routes->add('tickets', 'Admin\EventsController::tickets', ['as' => 'admin_event_tickets']);
        $routes->add('contacts', 'Admin\EventsController::contacts', ['as' => 'admin_event_contacts']);
        $routes->add('messages', 'Admin\EventsController::messages', ['as' => 'admin_event_messages']);

        $routes->add('add', 'Admin\EventsController::add', ['as' => 'admin_event_add']);
        $routes->add('details/(:num)', 'Admin\EventsController::details/$1', ['as' => 'admin_event_update']);
    });
});

$routes->group('film-zine', static function ($routes) {
    $routes->add('/', 'Admin\FilmZineController::index', ['as' => 'admin_film_zine']);
    $routes->group('/', static function ($routes) {
        $routes->add('topics', 'Admin\FilmZineController::topics', ['as' => 'admin_film_zine_topics']);
        $routes->add('types', 'Admin\FilmZineController::types', ['as' => 'admin_film_zine_types']);
        $routes->add('likes-log', 'Admin\FilmZineController::likes', ['as' => 'admin_film_zine_likes']);

        $routes->add('add', 'Admin\FilmZineController::addupdate', ['as' => 'admin_film_zine_add']);
        $routes->add('update/(:num)', 'Admin\FilmZineController::addupdate/$1', ['as' => 'admin_film_zine_update']);
    });
});
$routes->group('prime-watch', static function ($routes) {
    $routes->add('/', 'Admin\PrimWatchController::index', ['as' => 'admin_prime_watch']);
});

$routes->group('admin_store', static function ($routes) {
    $routes->add('/', 'Admin\StoreController::index', ['as' => 'admin_store']);
});

$routes->group('users', static function ($routes) {
    $routes->add('/', 'Admin\UsersController::index', ['as' => 'admin_users']);
    $routes->add('edit/(:any)', 'Admin\UsersController::editUser/$1', ['as' => 'admin_edit_user']);
    $routes->post('adduser', 'Admin\UsersController::addUser', ['as' => 'admin_add_user_ajax']);
});

$routes->group('settings', static function ($routes) {
    $routes->add('/', 'Admin\SettingsController::index', ['as' => 'admin_settings']);
    $routes->add('homepage-banners', 'Admin\SettingsController::homepageBanners', ['as' => 'admin_settings_homepage_banners']);
    $routes->add('support-forms', 'Admin\SettingsController::supportForms', ['as' => 'admin_settings_support_forms']);
    $routes->add('awards', 'Admin\SettingsController::filmFestivalAwards', ['as' => 'admin_settings_festival_awards']);
    $routes->add('film-types', 'Admin\SettingsController::filmTypes', ['as' => 'admin_settings_film_types']);
    $routes->add('homepage-filmzine', 'Admin\SettingsController::homepageFilmzine', ['as' => 'admin_settings_homepage_filmzine']);
    $routes->add('testimonials', 'Admin\SettingsController::testimonials', ['as' => 'admin_settings_testimonials']);
});
