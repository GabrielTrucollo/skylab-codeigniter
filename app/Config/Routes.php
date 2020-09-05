<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('User');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Router Login
 * --------------------------------------------------------------------
 */
$routes->get('/user/login', 'User::loginIndex');
$routes->post('/user/login', 'User::loginValidateCpf');
$routes->get('/user/login/password-required', 'User::loginPassword');
$routes->post('/user/login/password-required', 'User::loginValidatePassword');
$routes->get('/user/login/password-new', 'User::loginNewPassword');
$routes->post('/user/login/password-new', 'User::loginSaveNewPassword');

/**
 * --------------------------------------------------------------------
 * Router Dashboard
 * --------------------------------------------------------------------
 */
$routes->get('/', 'Dashboard::index', ['filter' => 'auth']);

/**
 * --------------------------------------------------------------------
 * Router User
 * --------------------------------------------------------------------
 */
$routes->get('/user/logOut', 'User::logOut', ['filter' => 'auth']);
$routes->get('/user/', 'User::index', ['filter' => 'auth']);
$routes->get('/user/getAll', 'User::getAll', ['filter' => 'auth']);
$routes->post('/user/save', 'User::save', ['filter' => 'auth']);

/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
