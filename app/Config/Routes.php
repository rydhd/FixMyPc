<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// --- AUTH ROUTES ---
// All of the auth routes the login for avoiding loping through
service('auth')->routes($routes, ['except' => ['login']]);

//Login routes.
$routes->get('/', 'LoginController::loginView');
$routes->get('login', '\App\Controllers\LoginController::loginView');
$routes->post('login', '\App\Controllers\LoginController::loginAction');


// --- DASHBOARD ROUTES ---
// A general dashboard for any logged-in user.
$routes->get('dashboard', 'InstructorController::dashboard', ['filter' => 'session']);
$routes->get('students', 'InstructorController::students', ['filter' => 'session']);

// The dashboard for master admins, protected by the group filter.
$routes->get('master-dashboard', 'MasterAdminController::dashboard', [
    'filter' => ['session', 'group:masteradmin,superadmin']
]);
// The dashboard for master admins, protected by the group filter.
$routes->get('master-students', 'MasterAdminController::students', [
    'filter' => ['session', 'group:masteradmin,superadmin']
]);