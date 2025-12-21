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
| ISO 00 — MASTER DOKUMEN
|--------------------------------------------------------------------------
*/
$routes->group('iso00', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Iso00Controller::index');
    $routes->get('create', 'Iso00Controller::create');
    $routes->post('store', 'Iso00Controller::store');
    $routes->get('edit/(:num)', 'Iso00Controller::edit/$1');
    $routes->post('update/(:num)', 'Iso00Controller::update/$1');
    $routes->get('show/(:num)', 'Iso00Controller::show/$1');
    $routes->get('view/(:num)', 'Iso00Controller::viewFile/$1');
});

/*
|--------------------------------------------------------------------------
| ISO 00 — HISTORY (DIPISAH)
|--------------------------------------------------------------------------
*/
$routes->group('iso00/history', ['filter' => 'auth'], function ($routes) {
    $routes->get('(:num)', 'HistoryIso00Controller::index/$1');      // history per dokumen
    $routes->get('all', 'HistoryIso00Controller::all');              // admin only
    $routes->get('view/(:num)', 'HistoryIso00Controller::view/$1');
    $routes->get('download/(:num)', 'HistoryIso00Controller::download/$1');
    $routes->get('delete/(:num)', 'HistoryIso00Controller::delete/$1');
});

/*
|--------------------------------------------------------------------------
| ISO ACCESS HOLDER (ADMIN ONLY)
|--------------------------------------------------------------------------
*/
$routes->group('access', ['filter' => 'role:admin'], function ($routes) {

    // MASTER HOLDER
    $routes->get('/', 'IsoAccessController::index');
    $routes->get('create', 'IsoAccessController::create');
    $routes->post('store-holder', 'IsoAccessController::storeHolder');

    // EDIT HOLDER (kode holder saja)
    $routes->get('edit/(:num)', 'IsoAccessController::edit/$1');
    $routes->post('update-holder/(:num)', 'IsoAccessController::updateHolder/$1');

    // EDIT DOKUMEN HOLDER
    $routes->get('edit-dokumen/(:num)', 'IsoAccessController::editDokumen/$1');
    $routes->post('update-dokumen/(:num)', 'IsoAccessController::updateDokumen/$1');

    // EDIT USERS HOLDER
    $routes->get('edit-users/(:num)', 'IsoAccessController::editUsers/$1');
    $routes->post('update-users/(:num)', 'IsoAccessController::updateUsers/$1');

    // DETAIL & ASSIGNMENT
    $routes->get('detail/(:segment)', 'IsoAccessController::detail/$1');
    $routes->get('assign/(:segment)', 'IsoAccessController::assign/$1');
    $routes->post('store-assignment', 'IsoAccessController::storeAssignment');

    // REMOVE / DELETE
    $routes->get('remove-user/(:num)', 'IsoAccessController::removeUser/$1');
    $routes->get('delete-holder/(:num)', 'IsoAccessController::deleteHolder/$1');

    // Tambahan (search / helper)
    $routes->get('search', 'IsoAccessController::search');
    $routes->get('user-fullname/(:num)', 'IsoAccessController::getUserFullname/$1');

    $routes->post('remove-dokumen', 'IsoAccessController::removeDokumen');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD DOKUMEN USER (BERDASARKAN HOLDER)
|--------------------------------------------------------------------------
*/
$routes->get('my-documents', 'IsoAccessController::userDocuments', ['filter' => 'auth']);

/*
|--------------------------------------------------------------------------
| BARCODE / QR CODE (LOGIN)
|--------------------------------------------------------------------------
*/
$routes->group('barcode', ['filter' => 'auth'], function ($routes) {

    // ===============================
    // HALAMAN
    // ===============================
    $routes->get('/', 'BarcodeController::list');           // admin & dept
    $routes->get('generate', 'BarcodeController::index');   // admin only (UI)

    // ===============================
    // AKSI ADMIN
    // ===============================
    $routes->get('generate/(:num)', 'BarcodeController::generate/$1');
    $routes->post('generate-bulk', 'BarcodeController::generateBulk');
    $routes->get('delete/(:num)', 'BarcodeController::delete/$1');

    // ===============================
    // DOWNLOAD PNG (ADMIN & DEPT)
    // ===============================
    $routes->get('print/(:num)', 'BarcodeController::print/$1');
});

/*
|--------------------------------------------------------------------------
| SCAN QR / BARCODE (PUBLIK - TANPA LOGIN)
|--------------------------------------------------------------------------
*/
$routes->get('scan', 'ScanController::form');
$routes->post('scan/process', 'ScanController::process');
$routes->get('scan/detail/(:num)', 'BarcodeController::detail/$1');
$routes->get('scan/file/(:num)', 'ScanController::file/$1');

/*
|--------------------------------------------------------------------------
| DASHBOARD ROLE
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
