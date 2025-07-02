<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// --- AUTH ROUTES ---

// Your custom routes should come FIRST
// This tells the app to use your controller for login and logout
$routes->get('login', 'LoginController::loginView');
$routes->post('login', 'LoginController::loginAction');
$routes->get('logout', 'LoginController::logoutAction');

// Registration
$routes->get('register', 'RegisterController::registerView');
$routes->post('register', 'RegisterController::registerAction');

// The default route. To protect it, add a filter.
// e.g., $routes->get('/', 'Home::index', ['filter' => 'session']);
$routes->get('/', 'Home::index');

// Now, load all of Shield's other routes, but EXCEPT the ones you've
// defined yourself. This prevents conflicts.
service('auth')->routes($routes, ['except' => ['login', 'logout']]);

// --- DASHBOARD ROUTES ---
// Grouping routes that require a logged-in session.
$routes->group('instructor', ['filter' => 'session'], function($routes) {
    // Corresponds to 'dashboard'
    $routes->get('dashboard', 'InstructorController::dashboard',['as' => 'dashboard']);

    // Corresponds to 'dashboard/students'
    $routes->get('students', 'InstructorController::students',['as' => 'students']);

});

$routes->group('master', ['filter' => ['session', 'group:masteradmin,superadmin']], static function ($routes) {
    // This route is now accessed via /master/dashboard
    // and is named 'master_dashboard' so redirect()->route() can find it.
    $routes->get('dashboard', 'MasterAdminController::dashboard', ['as' => 'master_dashboard']);

    // This route is accessed via /master/students
    $routes->get('students', 'MasterAdminController::students',['as' => 'master_students']);
    $routes->get('instructor', 'MasterAdminController::instructor',['as' => 'master_instructor']);


    // --- NEW ROUTES FOR ACCESS CODES ---
    $routes->get('access-codes', 'MasterAdminController::accessCodes',['as' => 'master_access_codes']);
    $routes->post('access-codes/generate', 'MasterAdminController::generateCode');
});