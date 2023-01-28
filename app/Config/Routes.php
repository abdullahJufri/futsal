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
$routes->post('api/admin/login', 'Api\Auth::login');
$routes->post('api/admin/register', 'Api\Auth::registration');

$routes->post('api/admin/futsal', 'Api\Admin\Futsal::list');
$routes->post('api/admin/insert', 'Api\Admin\Futsal::insert');

// $routes->post('api/admin/schedule', 'Api\Admin\Schedule::list');
$routes->post('api/admin/schedule', 'Api\Admin\Schedule::listOnline');
$routes->post('api/admin/check', 'Api\Admin\Check::list');

$routes->post('api/admin/futsal/update', 'Api\Admin\Futsal::update');



//for USER

$routes->post('api/login', 'Api\Auth::login');
$routes->post('api/register', 'Api\Auth::registration');

$routes->get('api/futsal', 'Api\Futsal::list');
$routes->post('api/futsal', 'Api\Futsal::list');
$routes->post('api/futsal/dd', 'Api\Futsal::dd_lapangan');

$routes->post('api/schedule', 'Api\Schedule::list');
$routes->post('api/schedule/insert', 'Api\Schedule::insert');

$routes->post('api/history', 'Api\History::list');
$routes->post('api/history/update', 'Api\History::update');

// midtrans
$routes->post('api/midtrans', 'Api\MidtransController::getSnapToken2');
// $routes->post('api/midtrans', 'Api\MidtransController::charge');
// $routes->post('api/midtrans/charge', 'Api\MidtransController::charge');

// // $routes->post('api/charge/', 'Api\ChargeController::test');
// $routes->post('api/charge/', 'Api\charge::index.php');
// $routes->post('api/charge/chargeAPI', 'Api\ChargeController::chargeAPI');




// $routes->get('api/futsal/list2', 'Api\Futsal::list/$1');


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
