<?php

namespace Config;

use CodeIgniter\Config\Services;

$routes = Services::routes();

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
$routes->get('/', 'HomeController::home');        
$routes->get('/login', 'AuthController::login');
$routes->post('/login/process', 'AuthController::process');
$routes->get('/logout', 'AuthController::logout');

/*
|--------------------------------------------------------------------------
| USER MANAGEMENT (ADMIN ONLY)
|--------------------------------------------------------------------------
*/
$routes->group('users', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'UserController::index');
    $routes->get('create', 'UserController::create');
    $routes->post('store', 'UserController::store');
    $routes->get('edit/(:num)', 'UserController::edit/$1');
    $routes->post('update/(:num)', 'UserController::update/$1');
    $routes->get('delete/(:num)', 'UserController::delete/$1');
});

/*
|--------------------------------------------------------------------------
| ISO 00 — Master Dokumen
|--------------------------------------------------------------------------
*/
$routes->group('iso00', ['filter' => 'auth'], function ($routes) {

    // Main pages
    $routes->get('/', 'Iso00Controller::index');
    $routes->get('create', 'Iso00Controller::create');
    $routes->post('store', 'Iso00Controller::store');
    $routes->get('edit/(:num)', 'Iso00Controller::edit/$1');
    $routes->post('update/(:num)', 'Iso00Controller::update/$1');
    $routes->get('delete/(:num)', 'Iso00Controller::delete/$1');

    // Viewing & downloading
    $routes->get('show/(:num)', 'Iso00Controller::show/$1');          
    $routes->get('view/(:num)', 'Iso00Controller::viewFile/$1');      
    $routes->get('download/(:num)', 'Iso00Controller::download/$1');  

    // History per file
    $routes->get('history/(:num)', 'Iso00Controller::history/$1');
    $routes->get('allHistory', 'Iso00Controller::allHistory');
    $routes->get('history/view/(:num)', 'Iso00Controller::viewHistoryFile/$1');
    $routes->get('history/download/(:num)', 'Iso00Controller::downloadHistoryFile/$1');
});

/*
|--------------------------------------------------------------------------
| HAK AKSES DOKUMEN (ISO ACCESS HOLDER)
| (ADMIN ONLY)
|--------------------------------------------------------------------------
*/
$routes->group('access', ['filter' => 'role:admin'], function ($routes) {

    // List semua hak akses
    $routes->get('/', 'IsoAccessController::index');

    // Form tambah hak akses
    $routes->get('create', 'IsoAccessController::create');

    // Simpan hak akses baru
    $routes->post('store', 'IsoAccessController::store');

    // Hapus hak akses
    $routes->get('delete/(:num)', 'IsoAccessController::delete/$1');

    // Pencarian berdasarkan Holder Code
    $routes->get('search', 'IsoAccessController::search');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD DOKUMEN USER BERDASARKAN HOLDER CODE
|--------------------------------------------------------------------------
*/
$routes->get('my-documents', 'IsoAccessController::userDocuments', ['filter' => 'auth']);

/*
|--------------------------------------------------------------------------
| BARCODE GENERATOR
|--------------------------------------------------------------------------
*/
$routes->group('barcode', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'BarcodeController::index');
    $routes->get('generate/(:num)', 'BarcodeController::generate/$1');
    $routes->post('generate-bulk', 'BarcodeController::generateBulk');
    $routes->get('delete/(:num)', 'BarcodeController::delete/$1');
    $routes->get('print/(:num)', 'BarcodeController::print/$1');
    $routes->get('file/(:num)', 'BarcodeController::file/$1');
});

/*
|--------------------------------------------------------------------------
| SCAN QR / BARCODE
|--------------------------------------------------------------------------
*/
$routes->get('scan', 'ScanController::form');
$routes->post('scan/process', 'ScanController::process');
$routes->get('scan/detail/(:num)', 'BarcodeController::detail/$1');
$routes->get('scan/file/(:num)', 'ScanController::file/$1');

/*
|--------------------------------------------------------------------------
| DASHBOARD ROLE BASED
|--------------------------------------------------------------------------
*/
$routes->get('/dashboard/admin', 'DashboardAdminController::index', ['filter' => 'role:admin']);
$routes->get('/dashboard/dept', 'DashboardDeptController::index', ['filter' => 'role:dept']);

/*
|--------------------------------------------------------------------------
| ACTIVITY LOG
|--------------------------------------------------------------------------
*/
$routes->group('activity', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'ActivityLogController::index');
    $routes->get('user/(:num)', 'ActivityLogController::userLog/$1');
});
