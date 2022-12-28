<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->setAutoRoute(false);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// $routes->resource('Futsal');


//for ADMIN
$routes->post('api/admin/login', 'api\Auth::login');
$routes->post('api/admin/register', 'api\Auth::registration');

$routes->post('api/admin/futsal', 'api\admin\Futsal::list');
$routes->post('api/admin/insert', 'api\admin\Futsal::insert');

$routes->post('api/admin/schedule', 'api\admin\Schedule::list');



//for USER

$routes->post('api/login', 'api\Auth::login');
$routes->post('api/register', 'api\Auth::registration');

$routes->get('api/futsal', 'api\Futsal::list');
$routes->post('api/futsal', 'api\Futsal::list');
$routes->post('api/futsal/dd', 'api\Futsal::dd_lapangan');

$routes->post('api/schedule', 'api\Schedule::list');
$routes->post('api/schedule/insert', 'api\Schedule::insert');

// midtrans
$routes->get('api/midtrans', 'api\MidtransController::getSnapToken');



// $routes->get('api/futsal/list2', 'api\Futsal::list/$1');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
