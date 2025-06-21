<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Tell Shield to generate all auth routes EXCEPT for the login routes
service('auth')->routes($routes, ['except' => ['login']]);
$routes->get('/', 'InstructorController::dashboard');

// Define our own custom login routes that point to our custom controller
$routes->get('login', '\App\Controllers\LoginController::loginView');
$routes->post('login', '\App\Controllers\LoginController::loginAction');


// --- CORRECTED FILTER SYNTAX ---
// Custom Dashboard Routes with filters applied as an array
$routes->get('master-dashboard', 'MasterAdminController::dashboard', [
    'filter' => ['session', 'group:masteradmin,superadmin']
]);
