<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Public routes (no auth required)
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login/process', 'Auth::process');
$routes->get('/logout', 'Auth::logout');

// Admin only routes (must be before pegawai catch-all)
$routes->group('', ['filter' => 'admin'], function ($routes) {
    $routes->get('/pegawai/manage', 'Pegawai::index');
    $routes->get('/pegawai/edit/(:any)', 'Pegawai::edit/$1');
    $routes->post('/pegawai/save', 'Pegawai::save');
    $routes->post('/pegawai/delete/(:any)', 'Pegawai::delete/$1');
    $routes->get('/rekening/manage', 'Rekening::index');
    $routes->get('/rekening/edit/(:num)', 'Rekening::edit/$1');
    $routes->post('/rekening/save', 'Rekening::save');
    $routes->post('/rekening/delete/(:num)', 'Rekening::delete/$1');
    $routes->get('/template/manage', 'Template::index');
    $routes->post('/template/upload', 'Template::upload');
    $routes->post('/template/replace', 'Template::replace');
    $routes->get('/template/preview/(:any)', 'Template::preview/$1');
    $routes->get('/template/download/(:any)', 'Template::download/$1');
    $routes->get('/template/edit/(:any)', 'Template::edit/$1');
    $routes->post('/template/saveEdit', 'Template::saveEdit');
    $routes->get('/users', 'Auth::users');
    $routes->get('/users/active', 'Auth::activeUsers');
    $routes->get('/users/create', 'Auth::createUser');
    $routes->post('/users/store', 'Auth::storeUser');
    $routes->get('/users/edit/(:num)', 'Auth::editUser/$1');
    $routes->post('/users/update/(:num)', 'Auth::updateUser/$1');
    $routes->post('/users/delete/(:num)', 'Auth::deleteUser/$1');
    $routes->post('/surat/history/delete/(:num)', 'Surat::deleteHistory/$1');
    $routes->post('/surat/history/delete-bulk', 'Surat::deleteBulkHistory');
    $routes->post('/surat/history/delete-rincian/(:num)', 'Surat::deleteRincian/$1');
    $routes->get('/pengaturan/perjadin', 'Pengaturan::index');
    $routes->post('/pengaturan/perjadin/update', 'Pengaturan::update');
    $routes->get('/pengaturan/dasar', 'Pengaturan::dasar');
    $routes->post('/pengaturan/dasar/update', 'Pengaturan::updateDasar');
    $routes->post('/pengaturan/dasar/add', 'Pengaturan::addDasar');
    $routes->post('/pengaturan/dasar/delete/(:num)', 'Pengaturan::deleteDasar/$1');
    $routes->get('/pengaturan/paraf', 'Pengaturan::paraf');
    $routes->post('/pengaturan/paraf/update', 'Pengaturan::updateParaf');
    $routes->post('/pengaturan/paraf/add', 'Pengaturan::addParaf');
    $routes->post('/pengaturan/paraf/delete/(:num)', 'Pengaturan::deleteParaf/$1');
    // Notifikasi admin
    $routes->get('/notifikasi', 'Notification::index');
    $routes->get('/notifikasi/create', 'Notification::create');
    $routes->post('/notifikasi/store', 'Notification::store');
    $routes->get('/notifikasi/edit/(:num)', 'Notification::edit/$1');
    $routes->post('/notifikasi/update/(:num)', 'Notification::update/$1');
    $routes->post('/notifikasi/toggle/(:num)', 'Notification::toggle/$1');
    $routes->post('/notifikasi/delete/(:num)', 'Notification::delete/$1');
});

// Auth required - all logged-in users
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/dashboard', 'Auth::dashboard');
    $routes->get('/notifikasi/active', 'Notification::active');

    // Surat generation (admin & user)
    $routes->get('/surat', 'Surat::index');
    $routes->post('/surat/proses', 'Surat::proses');
    $routes->get('/surat/download/(:segment)', 'Surat::download/$1');
    $routes->get('/surat/serve/(:segment)', 'Surat::serveDocx/$1');
    $routes->post('/surat/cetak', 'Surat::cetak');
    $routes->get('/surat/permohonantte', 'Surat::permohonantte');
    $routes->post('/surat/proses-tte', 'Surat::prosesPermohonanTTE');
    $routes->get('/surat/notadinastte', 'Surat::notadinastte');
    $routes->post('/surat/proses-notadinas', 'Surat::prosesNotaDinasTTE');
    $routes->get('/surat/notadinas-dari-permohonan/(:num)', 'Surat::notadinasDariPermohonan/$1');
    $routes->get('/surat/rincianperjadin', 'Surat::rincianperjadin');
    $routes->get('/surat/rincianperjadin/(:num)', 'Surat::rincianperjadin/$1');
    $routes->post('/surat/proses-rincian', 'Surat::prosesRincianPerjadin');
    $routes->get('/surat/kwitansi/(:num)', 'Surat::kwitansi/$1');
    $routes->post('/surat/proses-kwitansi', 'Surat::prosesKwitansi');
    $routes->post('/surat/history/delete-kwitansi/(:num)', 'Surat::deleteKwitansi/$1');
    $routes->post('/surat/history/delete-notadinas/(:num)', 'Surat::deleteNotaDinas/$1');
    $routes->get('/surat/history', 'Surat::history');
    $routes->get('/surat/edit/(:num)', 'Surat::editSurat/$1');
    $routes->post('/surat/update/(:num)', 'Surat::updateSurat/$1');
    $routes->get('/profil', 'Auth::profil');
    $routes->post('/profil/update', 'Auth::updateProfil');

    // Pegawai API (catch-all, must be last)
    $routes->get('/pegawai/(:any)', 'Surat::getPegawai/$1');
});