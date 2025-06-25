<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- AUTH ROUTES ---
// Generate all auth routes EXCEPT for the login routes.
service('auth')->routes($routes, ['except' => ['login']]);

// Define our own custom login routes.
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