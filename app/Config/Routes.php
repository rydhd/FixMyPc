<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

// --- AUTH ROUTES ---

// Your custom routes should come FIRST
// This tells the app to use your controller for login and logout
$routes->get('login', 'LoginController::loginView');
$routes->post('login', 'LoginController::loginAction');
$routes->get('logout', 'LoginController::logoutAction');

// Registration
$routes->get('register', 'RegisterController::registerView');
$routes->post('register', 'RegisterController::registerAction');


// --- DASHBOARD ROUTES ---
// Grouping routes that require a logged-in session.
$routes->group('instructor', ['filter' => 'session'], function($routes) {
    // Corresponds to 'dashboard'
    $routes->get('dashboard', 'InstructorController::dashboard',['as' => 'dashboard']);

    $routes->get('students', 'InstructorController::students', ['as' => 'students']);
    $routes->post('classlist/upload', 'InstructorController::uploadClasslist');
    $routes->post('students/delete/(:num)', 'InstructorController::deleteStudent/$1');

// Handles showing the edit form
    $routes->get('students/edit/(:num)', 'InstructorController::edit/$1');

// Handles the submission of the edit form
    $routes->post('students/update/(:num)', 'InstructorController::update/$1');

    // ✅ ADD THIS LINE FOR THE DELETE ALL ACTION
    $routes->post('students/delete-all', 'InstructorController::deleteAllStudents');

});

// --- MASTER ADMIN ROUTES ---
$routes->group('master', ['filter' => ['session', 'group:masteradmin,superadmin']], static function ($routes) {
    // This route is now accessed via /master/dashboard
    // and is named 'master_dashboard' so redirect()->route() can find it.
    $routes->get('dashboard', 'MasterAdminController::dashboard', ['as' => 'master_dashboard']);

    // This route is accessed via /master/students
    $routes->get('students', 'MasterAdminController::students',['as' => 'master_students']);
    $routes->get('instructor', 'MasterAdminController::instructor',['as' => 'master_instructor']);

    $routes->get('students/edit/(:num)', 'MasterAdminController::edit/$1');
    $routes->post('students/update/(:num)', 'MasterAdminController::update/$1');
    $routes->post('students/delete/(:num)', 'MasterAdminController::deleteStudent/$1');

    // --- Corrected Routes for Access Codes ---

    // Defines the route for displaying the list of access codes.
    // GET /master/access-codes -> MasterAdminController::accessCodes()
    $routes->get('access-codes', 'MasterAdminController::accessCodes', ['as' => 'master_access_codes']);

    // Defines the route for the "Generate Code" button's POST request.
    // POST /master/generate-code -> MasterAdminController::generateCode()
    $routes->post('generate-code', 'MasterAdminController::generateCode', ['as' => 'master_generate_code']);
});

service('auth')->routes($routes);
