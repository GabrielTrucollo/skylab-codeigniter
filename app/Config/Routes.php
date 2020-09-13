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
$routes->get('/user/(:num)', 'User::getById/$1', ['filter' => 'auth']);
$routes->get('/user/getAll', 'User::getAll', ['filter' => 'auth']);
$routes->post('/user/save', 'User::save', ['filter' => 'auth']);
$routes->delete('/user/(:num)', 'User::delete/$1', ['filter' => 'auth']);

/**
 * --------------------------------------------------------------------
 * Router Software
 * --------------------------------------------------------------------
 */
$routes->get('/software/', 'Software::index', ['filter' => 'auth']);
$routes->get('/software/(:num)', 'Software::getById/$1', ['filter' => 'auth']);
$routes->get('/software/getAll', 'Software::getAll', ['filter' => 'auth']);
$routes->get('/software/getAllActive', 'Software::getAllActive', ['filter' => 'auth']);
$routes->post('/software/save', 'Software::save', ['filter' => 'auth']);
$routes->delete('/software/(:num)', 'Software::delete/$1', ['filter' => 'auth']);

/**
 * --------------------------------------------------------------------
 * Router Payment-Type
 * --------------------------------------------------------------------
 */
$routes->get('/payment-type/', 'PaymentType::index', ['filter' => 'auth']);
$routes->get('/payment-type/(:num)', 'PaymentType::getById/$1', ['filter' => 'auth']);
$routes->get('/payment-type/getAll', 'PaymentType::getAll', ['filter' => 'auth']);
$routes->get('/payment-type/getAllActive', 'PaymentType::getAllActive', ['filter' => 'auth']);
$routes->post('/payment-type/save', 'PaymentType::save', ['filter' => 'auth']);
$routes->delete('/payment-type/(:num)', 'PaymentType::delete/$1', ['filter' => 'auth']);

/**
 * --------------------------------------------------------------------
 * Router AttendanceReason
 * --------------------------------------------------------------------
 */
$routes->get('/attendance-reason/', 'AttendanceReason::index', ['filter' => 'auth']);
$routes->get('/attendance-reason/(:num)', 'AttendanceReason::getById/$1', ['filter' => 'auth']);
$routes->get('/attendance-reason/getAll', 'AttendanceReason::getAll', ['filter' => 'auth']);
$routes->get('/attendance-reason/getAllActive', 'AttendanceReason::getAllActive', ['filter' => 'auth']);
$routes->post('/attendance-reason/save', 'AttendanceReason::save', ['filter' => 'auth']);
$routes->delete('/attendance-reason/(:num)', 'AttendanceReason::delete/$1', ['filter' => 'auth']);

/**
 * --------------------------------------------------------------------
 * Router AttendanceType
 * --------------------------------------------------------------------
 */
$routes->get('/attendance-type/', 'AttendanceType::index', ['filter' => 'auth']);
$routes->get('/attendance-type/(:num)', 'AttendanceType::getById/$1', ['filter' => 'auth']);
$routes->get('/attendance-type/getAll', 'AttendanceType::getAll', ['filter' => 'auth']);
$routes->post('/attendance-type/save', 'AttendanceType::save', ['filter' => 'auth']);
$routes->delete('/attendance-type/(:num)', 'AttendanceType::delete/$1', ['filter' => 'auth']);

/**
 * --------------------------------------------------------------------
 * Router Client
 * --------------------------------------------------------------------
 */
$routes->get('/client/', 'Client::index', ['filter' => 'auth']);
$routes->get('/client/(:num)', 'Client::getById/$1', ['filter' => 'auth']);
$routes->get('/client/getAll', 'Client::getAll', ['filter' => 'auth']);
$routes->get('/client/getAllActive', 'Client::getAllActive', ['filter' => 'auth']);
$routes->post('/client/save', 'Client::save', ['filter' => 'auth']);
$routes->delete('/client/(:num)', 'Client::delete/$1', ['filter' => 'auth']);

/**
 * --------------------------------------------------------------------
 * Router Accounting
 * --------------------------------------------------------------------
 */
$routes->get('/accounting/', 'Accounting::index', ['filter' => 'auth']);
$routes->get('/accounting/(:num)', 'Accounting::getById/$1', ['filter' => 'auth']);
$routes->get('/accounting/getAll', 'Accounting::getAll', ['filter' => 'auth']);
$routes->get('/accounting/getAllActive', 'Accounting::getAllActive', ['filter' => 'auth']);
$routes->post('/accounting/save', 'Accounting::save', ['filter' => 'auth']);
$routes->delete('/accounting/(:num)', 'Accounting::delete/$1', ['filter' => 'auth']);

/**
 * --------------------------------------------------------------------
 * Router Attendance
 * --------------------------------------------------------------------
 */
$routes->get('/attendance/', 'Attendance::index', ['filter' => 'auth']);
$routes->get('/attendance/(:num)', 'Attendance::getById/$1', ['filter' => 'auth']);
$routes->get('/attendance/getAll', 'Attendance::getAll', ['filter' => 'auth']);
$routes->post('/attendance/save', 'Attendance::save', ['filter' => 'auth']);
$routes->delete('/attendance/(:num)', 'Attendance::delete/$1', ['filter' => 'auth']);

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
