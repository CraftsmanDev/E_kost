<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'AuthController::login');
$routes->get('login', 'AuthController::login');
$routes->get('register', 'AuthController::Register');
$routes->post('login/store', 'AuthController::store');
$routes->post('register/store', 'AuthController::storeRegister');
$routes->get('logout', 'AuthController::logout');

$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'DashboardController::index');
    $routes->get('kost', 'KostController::index');
    $routes->get('permintaan-sewa', 'PermintaanSewaController::index');
    $routes->get('pembayaran', 'PembayaranController::index');
    $routes->get('penghuni', 'PenghuniController::index');
    $routes->get('pengajuan-berhenti', 'BerhentiSewaController::index');
    $routes->get('pengguna', 'PenggunaController::index');
    $routes->get('laporan-keuangan', 'LaporanKeuanganController::index');
    $routes->get('laporan-penyewa', 'LaporanPenyewaController::index');

    $routes->get('add/kost', 'KostController::Tambah');
    $routes->get('kost/table', 'KostController::table');
    $routes->get('permintaan-sewa/table', 'PermintaanSewaController::table');
    $routes->get('pembayaran/table', 'PembayaranController::table');
    $routes->get('penghuni/table', 'PenghuniController::table');
    $routes->get('pengajuan-berhenti/table', 'BerhentiSewaController::table');
    $routes->get('pengguna/table', 'PenggunaController::table');
    $routes->get('laporan-keuangan/table', 'LaporanKeuanganController::table');
    $routes->get('laporan-penyewa/table', 'LaporanPenyewaController::table');

    $routes->get('pengguna/tambah', 'PenggunaController::tambah');
    $routes->post('pengguna/simpan', 'PenggunaController::simpan');
    $routes->get('pengguna/detail/(:num)', 'PenggunaController::detail/$1');
    $routes->get('pengguna/edit/(:num)', 'PenggunaController::edit/$1');
    $routes->post('pengguna/update/(:num)', 'PenggunaController::update/$1');
    $routes->get('pengguna/hapus/(:num)', 'PenggunaController::hapus/$1');
    $routes->get('pengguna/toggle-status/(:num)', 'PenggunaController::toggleStatus/$1');

    $routes->post('kost/store', 'KostController::Store');
    $routes->get('kost/detail/(:num)', 'KostController::detail/$1');
    $routes->get('kost/edit/(:num)', 'KostController::edit/$1');
    $routes->post('kost/update/(:num)', 'KostController::update/$1');
    $routes->get('kost/delete/(:num)', 'KostController::delete/$1');
    $routes->get('kamar/(:num)', 'KamarController::index/$1');
    $routes->get('kamar/(:num)/table', 'KamarController::table/$1');
    $routes->get('kamar/(:num)/stats', 'KamarController::stats/$1');
    $routes->get('kamar/(:num)/create', 'KamarController::create/$1');
    $routes->post('kamar/(:num)/store', 'KamarController::store/$1');
    $routes->get('kamar/(:num)/edit/(:num)', 'KamarController::edit/$1/$2');
    $routes->post('kamar/(:num)/update/(:num)', 'KamarController::update/$1/$2');
    $routes->get('kamar/(:num)/delete/(:num)', 'KamarController::delete/$1/$2');
    $routes->get('kamar/(:num)/pesan/(:num)', 'KamarController::pesan/$1/$2');


    $routes->get('permintaan-sewa/detail/(:num)', 'PermintaanSewaController::detail/$1');
    $routes->get('permintaan-sewa/approve/(:num)', 'PermintaanSewaController::approve/$1');
    $routes->get('permintaan-sewa/reject/(:num)', 'PermintaanSewaController::reject/$1');

    $routes->get('pembayaran/detail/(:num)', 'PembayaranController::detail/$1');
    $routes->get('pembayaran/approve/(:num)', 'PembayaranController::approve/$1');
    $routes->get('pembayaran/reject/(:num)', 'PembayaranController::reject/$1');
    $routes->get('pembayaran/upload-bukti/(:num)', 'PembayaranController::formUpload/$1');
    $routes->post('pembayaran/upload-bukti/(:num)', 'PembayaranController::uploadBukti/$1');

    $routes->get('penghuni/detail/(:num)', 'PenghuniController::detail/$1');
    $routes->get('penghuni/edit/(:num)', 'PenghuniController::edit/$1');
    $routes->post('penghuni/update/(:num)', 'PenghuniController::update/$1');
    $routes->get('penghuni/delete/(:num)', 'PenghuniController::delete/$1');

    $routes->get('pengajuan-berhenti/store/(:num)', 'BerhentiSewaController::exit/$1');
    $routes->post('pengajuan-berhenti/storeExit/(:num)', 'BerhentiSewaController::storeExit/$1');
    $routes->get('pengajuan-berhenti/detail/(:num)', 'BerhentiSewaController::detail/$1');
    $routes->get('pengajuan-berhenti/approve/(:num)', 'BerhentiSewaController::approve/$1');
    $routes->get('pengajuan-berhenti/reject/(:num)', 'BerhentiSewaController::reject/$1');

    // Profile routes
    $routes->get('profile', 'ProfileController::index');
    $routes->get('profile/edit', 'ProfileController::edit');
    $routes->post('profile/update', 'ProfileController::update');
    $routes->get('profile/change-password', 'ProfileController::change_Password');
    $routes->post('profile/change-password', 'ProfileController::changePassword');

    // Notification routes
    $routes->get('notifikasi/get', 'NotifikasiController::getNotifikasi');
    $routes->get('notifikasi/unread-count', 'NotifikasiController::getUnreadCount');
    $routes->post('notifikasi/mark-read/(:num)', 'NotifikasiController::markAsRead/$1');
    $routes->post('notifikasi/mark-all-read', 'NotifikasiController::markAllAsRead');
    $routes->post('notifikasi/delete/(:num)', 'NotifikasiController::delete/$1');

    // Report export routes
    $routes->get('laporan-keuangan/export', 'LaporanKeuanganController::exportExcel');
    $routes->get('laporan-penyewa/export', 'LaporanPenyewaController::exportExcel');

    $routes->get('search-kost', 'DashboardController::searchKost');
    $routes->get('search-kost-location', 'DashboardController::searchKostByLocation');
    $routes->get('filter-data', 'DashboardController::getFilterData');
});
