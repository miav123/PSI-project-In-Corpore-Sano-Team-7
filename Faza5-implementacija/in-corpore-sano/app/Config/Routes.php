<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Usercontroller');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

/*
 *  LOGIN/REGISTER ROUTES
 */
$routes->match(['post', 'get'],'/', 'Loginregister\Logincontroller::login');
$routes->match(['post', 'get'],'register', 'Loginregister\Registercontroller::register');
$routes->match(['post', 'get'],'registercontinue', 'Loginregister\Registercontroller::registercontinue');
$routes->get('logout', 'Loginregister\Logincontroller::logout');

/*
 *  ADMIN ROUTES
 */
$routes->group('admin', function ($routes) {
    $routes->get('challenges', 'Admin\Challengescontroller::allchallenges');
    $routes->post('deletechallenge/(:any)', 'Admin\Challengescontroller::deletechallenge/$1');
    $routes->get('trainers', 'Admin\Trainercontroller::alltrainers');
    $routes->post('deletetrainer/(:any)', 'Admin\Trainercontroller::deletetrainer/$1');
    $routes->get('users', 'Admin\Usercontroller::allusers');
    $routes->post('deleteuser/(:any)', 'Admin\Usercontroller::deleteuser/$1');
});

/*
 *  USER ROUTES
 */
$routes->group('user', function ($routes) {
    //DAILY LOG
    $routes->get('current-challenges', 'User\Currentchallengescontroller::currChallenges');
    $routes->post('acceptchallenge/(:any)', 'User\Currentchallengescontroller::acceptchallenge/$1');
    $routes->get('my-challenges', 'User\Mychallengescontroller::myChallenges');
    $routes->post('leavechallenge/(:any)', 'User\Mychallengescontroller::leavechallenge/$1');
    $routes->get('done-challenges', 'User\Donechallengescontroller::doneChallenges');
    $routes->post('likechallenge/(:any)', 'User\DonechallengesController::likechallenge/$1');
    $routes->add('charts/(:any)', 'User\Chartscontroller::chart/$1');
    //BADGES
    $routes->get('rank', 'User\Rankcontroller::allRegUsers');
    $routes->get('my-account', 'User\Myaccountcontroller::myAccountUser');
    $routes->post('changeUsername', 'User\Myaccountcontroller::changeUsername');
    $routes->post('changeHeight', 'User\Myaccountcontroller::changeHeight');
    $routes->post('changeWeight', 'User\Myaccountcontroller::changeWeight');
    $routes->post('changeHours', 'User\Myaccountcontroller::changeHours');
    $routes->post('changePassword', 'User\Myaccountcontroller::changePassword');
    $routes->post('changeEmail', 'User\Myaccountcontroller::changeEmail');
});

/*
 *  TRAINER ROUTES
 */


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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
