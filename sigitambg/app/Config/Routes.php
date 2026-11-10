<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->post('/login', 'Auth::processLogin');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/logout', 'Auth::logout');
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
});

$routes->group('master', ['filter' => 'auth'], function ($routes) {

    $routes->get('users', 'Master\Users::index');
    $routes->get('users/create', 'Master\Users::create');
    $routes->post('users/store', 'Master\Users::store');
    $routes->get('users/edit/(:num)', 'Master\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Master\Users::update/$1');
    $routes->get('users/delete/(:num)', 'Master\Users::delete/$1');
});

$routes->group('gizi', ['filter' => 'auth'], function ($routes) {

    $routes->get('menu', 'Gizi\Menu::index');
    $routes->get('menu/create', 'Gizi\Menu::create');
    $routes->post('menu/store', 'Gizi\Menu::store');
    $routes->get('menu/list', 'Gizi\Menu::list');
    $routes->get('menu/detail/(:num)', 'Gizi\Menu::detail/$1');
    $routes->get('menu/edit/(:num)', 'Gizi\Menu::edit/$1');
    $routes->post('menu/update/(:num)', 'Gizi\Menu::update/$1');
    $routes->get('menu/delete/(:num)', 'Gizi\Menu::delete/$1');
    $routes->get('bahan', 'Gizi\Bahan::index');
    $routes->post('bahan/store', 'Gizi\Bahan::store');
    $routes->get('bahan/delete/(:num)', 'Gizi\Bahan::delete/$1');
    $routes->post('bahan/update/(:num)', 'Gizi\Bahan::update/$1');
    $routes->post('bahan/toggle-status/(:num)', 'Gizi\Bahan::toggleStatus/$1');
    $routes->get('bahan/history/(:num)', 'Gizi\Bahan::history/$1');
    $routes->get('bahan-baku', 'Gizi\BahanBaku::index');
    $routes->get('bahan-baku/create', 'Gizi\BahanBaku::create');
    $routes->post('bahan-baku/store', 'Gizi\BahanBaku::store');
    $routes->get('bahan-baku/detail/(:num)', 'Gizi\BahanBaku::detail/$1');
    $routes->post('bahan-baku/delete/(:num)', 'Gizi\BahanBaku::delete/$1');
    $routes->post('bahan-baku/store-detail', 'Gizi\BahanBaku::storeDetail');
    $routes->get('data-pm', 'Gizi\DataPM::index');
    $routes->get('produksi', 'Gizi\Produksi::index');
    $routes->get('bahan-baku/ajukan/(:num)', 'Gizi\BahanBaku::ajukan/$1');
    $routes->post('bahan-baku/ajukan/(:num)', 'Gizi\BahanBaku::ajukan/$1');
    $routes->get('bahan-baku/delete-detail/(:num)', 'Gizi\BahanBaku::deleteDetail/$1');
    $routes->post('bahan-baku/update-detail/(:num)', 'Gizi\BahanBaku::updateDetail/$1');
    $routes->get('kegiatan', 'Gizi\Kegiatan::index');
    $routes->get('kegiatan/create', 'Gizi\Kegiatan::create');
    $routes->post('kegiatan/store', 'Gizi\Kegiatan::store');
    $routes->get('kegiatan/detail/(:num)', 'Gizi\Kegiatan::detail/$1');
    $routes->get('kegiatan/edit/(:num)', 'Gizi\Kegiatan::edit/$1');
    $routes->post('kegiatan/update/(:num)', 'Gizi\Kegiatan::update/$1');
    $routes->get('rencana-menu', 'Gizi\RencanaMenu::index');
    $routes->get('rencana-menu/create', 'Gizi\RencanaMenu::create');
    $routes->post('rencana-menu/store', 'Gizi\RencanaMenu::store');
    $routes->get('rencana-menu/edit/(:num)', 'Gizi\RencanaMenu::edit/$1');
    $routes->get('rencana-menu/detail/(:num)', 'Gizi\RencanaMenu::detail/$1');
    $routes->get('rencana-menu/delete/(:num)', 'Gizi\RencanaMenu::delete/$1');
    $routes->get('rencana-menu/tetapkan/(:num)', 'Gizi\RencanaMenu::tetapkan/$1');
    $routes->post('rencana-menu/tetapkan/(:num)', 'Gizi\RencanaMenu::tetapkan/$1');
    $routes->post('rencana-menu/update/(:num)', 'Gizi\RencanaMenu::update/$1');
    $routes->post('rencana-menu/batalkan/(:num)', 'Gizi\RencanaMenu::batalkan/$1');
    $routes->get('menu/varian/(:num)', 'Gizi\MenuVarian::create/$1');
    $routes->post('menu/varian/store/(:num)', 'Gizi\MenuVarian::store/$1');
    $routes->get('rencana-menu/pdf/(:num)', 'Gizi\RencanaMenu::pdf/$1');
    $routes->get('bahan/request', 'Gizi\BahanRequest::index', ['filter' => 'auth']);
    $routes->get('bahan/request/create', 'Gizi\BahanRequest::create', ['filter' => 'auth']);
    $routes->post('bahan/request/store', 'Gizi\BahanRequest::store', ['filter' => 'auth']);
});



$routes->group('aslap', ['filter' => 'auth'], function ($routes) {

    $routes->get('penerima-manfaat', 'Aslap\PenerimaManfaat::index');
    $routes->post('penerima-manfaat/store', 'Aslap\PenerimaManfaat::store');
    $routes->get('penerima-manfaat/detail/(:num)', 'Aslap\PenerimaManfaat::detail/$1');
    $routes->get('penerima-manfaat/delete/(:num)', 'Aslap\PenerimaManfaat::delete/$1');
    $routes->get('penerima-manfaat/detail/(:num)', 'Aslap\PenerimaManfaat::detail/$1');
    $routes->post('penerima-manfaat/store-kelas', 'Aslap\PenerimaManfaat::storeKelas');
    $routes->post('penerima-manfaat/update-kelas/(:num)', 'Aslap\PenerimaManfaat::updateKelas/$1');
    $routes->get('penerima-manfaat/delete-kelas/(:num)', 'Aslap\PenerimaManfaat::deleteKelas/$1');
    $routes->post('penerima-manfaat/update-pm/(:num)', 'Aslap\PenerimaManfaat::updatePM/$1');
    $routes->get('kegiatan', 'Aslap\Kegiatan::index');
    $routes->get('kegiatan/create', 'Aslap\Kegiatan::create');
    $routes->post('kegiatan/store', 'Aslap\Kegiatan::store');
    $routes->get('kegiatan/detail/(:num)', 'Aslap\Kegiatan::detail/$1');
    $routes->get('kegiatan/edit/(:num)', 'Aslap\Kegiatan::edit/$1');
    $routes->post('kegiatan/update/(:num)', 'Aslap\Kegiatan::update/$1');
    $routes->get('kegiatan/delete/(:num)', 'Aslap\Kegiatan::delete/$1');
    $routes->post('kegiatan/upload-foto/(:num)', 'Aslap\Kegiatan::uploadFoto/$1');
    $routes->get('kegiatan/delete-foto/(:num)', 'Aslap\Kegiatan::deleteFoto/$1');
    $routes->get('pengeluaran', 'Aslap\Pengeluaran::index');
    $routes->get('pengeluaran/create', 'Aslap\Pengeluaran::create');
    $routes->post('pengeluaran/store', 'Aslap\Pengeluaran::store');
    $routes->get('pengeluaran/detail/(:num)', 'Aslap\Pengeluaran::detail/$1');
    $routes->get('pengeluaran/edit/(:num)', 'Aslap\Pengeluaran::edit/$1');
    $routes->post('pengeluaran/update/(:num)', 'Aslap\Pengeluaran::update/$1');
    $routes->get('pengeluaran/delete/(:num)', 'Aslap\Pengeluaran::delete/$1');
    $routes->get('pengeluaran/edit/(:num)', 'Aslap\Pengeluaran::edit/$1');
    $routes->post('pengeluaran/update/(:num)', 'Aslap\Pengeluaran::update/$1');
    $routes->get('pengeluaran/delete/(:num)', 'Aslap\Pengeluaran::delete/$1');
    $routes->get('laporan', 'Aslap\Laporan::index');
    $routes->get('laporan/export-excel', 'Aslap\Laporan::exportExcel');
    $routes->get('laporan/pdf', 'Aslap\Laporan::exportPdf');
    $routes->post('penerima-manfaat/store-jenjang', 'Aslap\PenerimaManfaat::storeJenjang');
    $routes->get('penerima-manfaat/jenjang/(:num)', 'Aslap\PenerimaManfaat::detailJenjang/$1');
    $routes->post('penerima-manfaat/delete-jenjang/(:num)', 'Aslap\PenerimaManfaat::deleteJenjang/$1');
    $routes->post('penerima-manfaat/delete-kelas/(:num)', 'Aslap\PenerimaManfaat::deleteKelas/$1');
});

// ============================================================
// KEUANGAN
// ============================================================
$routes->group('keuangan', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Keuangan\Dashboard::index');
    $routes->get('pengadaan', 'Keuangan\Pengadaan::index');
    $routes->get('pengadaan/detail/(:num)', 'Keuangan\Pengadaan::detail/$1');
    $routes->get('pengadaan/invoice/(:num)', 'Keuangan\Pengadaan::invoice/$1');
    $routes->post('pengadaan/approve/(:num)', 'Keuangan\Pengadaan::approve/$1');
    $routes->post('pengadaan/reject/(:num)', 'Keuangan\Pengadaan::reject/$1');
    $routes->get('laporan', 'Keuangan\Laporan::index');
    $routes->get('laporan/pdf', 'Keuangan\Laporan::pdf');
    $routes->get('petty-cash', 'Keuangan\PettyCash::index');
    $routes->post('petty-cash/store', 'Keuangan\PettyCash::store');
    $routes->post('petty-cash/update/(:num)', 'Keuangan\PettyCash::update/$1');
    $routes->post('petty-cash/delete/(:num)', 'Keuangan\PettyCash::delete/$1');
});

// ============================================================
// KEPALA SPPG
// ============================================================
$routes->group('kepala', ['filter' => 'auth'], function ($routes) {
    $routes->get('pengadaan', 'Kepala\Pengadaan::index');
    $routes->get('pengadaan/detail/(:num)', 'Kepala\Pengadaan::detail/$1');
    $routes->post('pengadaan/approve/(:num)', 'Kepala\Pengadaan::approve/$1');
    $routes->post('pengadaan/reject/(:num)', 'Kepala\Pengadaan::reject/$1');
});

// ============================================================
// KOPERASI
// ============================================================
$routes->group('koperasi', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Koperasi\Dashboard::index');
    $routes->post('sppg/select', 'Koperasi\Dashboard::selectSppg');
    $routes->get('supplier', 'Koperasi\Supplier::index');
    $routes->get('supplier/create', 'Koperasi\Supplier::create');
    $routes->post('supplier/store', 'Koperasi\Supplier::store');
    $routes->get('supplier/edit/(:num)', 'Koperasi\Supplier::edit/$1');
    $routes->post('supplier/update/(:num)', 'Koperasi\Supplier::update/$1');
    $routes->get('supplier/detail/(:num)', 'Koperasi\Supplier::detail/$1');
    $routes->get('supplier/delete/(:num)', 'Koperasi\Supplier::delete/$1');
    $routes->post('supplier/jenis/store', 'Koperasi\Supplier::storeJenis');
    $routes->post('supplier/jenis/toggle/(:num)', 'Koperasi\Supplier::toggleJenis/$1');
    $routes->post('supplier/document/upload/(:num)', 'Koperasi\Supplier::uploadDocument/$1');
    $routes->post('supplier/document/delete/(:num)', 'Koperasi\Supplier::deleteDocument/$1');
    $routes->post('supplier/link-bahan/(:num)', 'Koperasi\Supplier::linkBahan/$1');
    $routes->post('supplier/update-harga/(:num)', 'Koperasi\Supplier::updateHargaBahan/$1');
    $routes->get('supplier/history-harga/(:num)', 'Koperasi\Supplier::historyHarga/$1');
    $routes->get('bahan', 'Koperasi\Bahan::index');
    $routes->post('bahan/store', 'Koperasi\Bahan::store');
    $routes->post('bahan/copy', 'Koperasi\Bahan::copy');
    $routes->get('bahan/template-excel', 'Koperasi\Bahan::templateExcel');
    $routes->post('bahan/import-excel', 'Koperasi\Bahan::importExcel');
    $routes->post('bahan/update-unit/(:num)', 'Koperasi\Bahan::updateUnit/$1');
    $routes->post('bahan/update-harga/(:num)', 'Koperasi\Bahan::updateHarga/$1');
    $routes->get('bahan/history/(:num)', 'Koperasi\Bahan::history/$1');
    $routes->get('pengadaan', 'Koperasi\Pengadaan::index');
    $routes->get('pengadaan/detail/(:num)', 'Koperasi\Pengadaan::detail/$1');
    $routes->post('pengadaan/process/(:num)', 'Koperasi\Pengadaan::process/$1');
    $routes->post('pengadaan/complete/(:num)', 'Koperasi\Pengadaan::complete/$1');
    $routes->get('pembelian', 'Koperasi\Pembelian::index');
    $routes->get('pembelian/create/(:num)', 'Koperasi\Pembelian::create/$1');
    $routes->get('pembelian/detail/(:num)', 'Koperasi\Pembelian::detail/$1');
    $routes->post('pembelian/update/(:num)', 'Koperasi\Pembelian::update/$1');
    $routes->post('pembelian/dibeli/(:num)', 'Koperasi\Pembelian::markPurchased/$1');
    $routes->post('pembelian/kirim/(:num)', 'Koperasi\Pembelian::send/$1');
    $routes->get('pembelian/pdf/(:num)', 'Koperasi\Pembelian::pdf/$1');
    $routes->get('laporan-pembelian', 'Koperasi\Pembelian::laporan');
    $routes->get('laporan-pembelian/pdf', 'Koperasi\Pembelian::laporanPdf');
    $routes->get('request-bahan', 'Koperasi\BahanRequest::index');
    $routes->post('request-bahan/approve/(:num)', 'Koperasi\BahanRequest::approve/$1');
    $routes->post('request-bahan/reject/(:num)', 'Koperasi\BahanRequest::reject/$1');
});


// ============================================================
// ADMINISTRATOR PUSAT
// ============================================================
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('users', 'Admin\Users::index');
    $routes->get('aktivitas', 'Admin\Activity::index');
    $routes->get('laporan', 'Admin\Laporan::index');
    $routes->post('users/toggle/(:num)', 'Admin\Users::toggle/$1');
    $routes->post('users/reset-password/(:num)', 'Admin\Users::resetPassword/$1');
});

$routes->group('super-admin', ['filter' => 'superadmin'], function ($routes) {
    $routes->get('/', 'SuperAdmin\Dashboard::index');
    $routes->get('sppg', 'SuperAdmin\Sppg::index');
    $routes->post('sppg/store', 'SuperAdmin\Sppg::store');
    $routes->get('sppg/edit/(:segment)', 'SuperAdmin\Sppg::edit/$1');
    $routes->post('sppg/update/(:segment)', 'SuperAdmin\Sppg::update/$1');
    $routes->post('sppg/toggle/(:segment)', 'SuperAdmin\Sppg::toggle/$1');

    $routes->get('koperasi', 'SuperAdmin\Koperasi::index');
    $routes->get('koperasi/create', 'SuperAdmin\Koperasi::create');
    $routes->post('koperasi/store', 'SuperAdmin\Koperasi::store');
    $routes->get('koperasi/edit/(:num)', 'SuperAdmin\Koperasi::edit/$1');
    $routes->post('koperasi/update/(:num)', 'SuperAdmin\Koperasi::update/$1');
    $routes->get('koperasi/detail/(:num)', 'SuperAdmin\Koperasi::detail/$1');
    $routes->post('koperasi/assign/(:num)', 'SuperAdmin\Koperasi::assign/$1');
    $routes->post('koperasi/toggle/(:num)', 'SuperAdmin\Koperasi::toggle/$1');
    $routes->post('koperasi/delete/(:num)', 'SuperAdmin\Koperasi::delete/$1');

    $routes->get('users', 'SuperAdmin\Users::index');
    $routes->get('users/create', 'SuperAdmin\Users::create');
    $routes->post('users/store', 'SuperAdmin\Users::store');
    $routes->get('users/edit/(:num)', 'SuperAdmin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'SuperAdmin\Users::update/$1');
    $routes->post('users/toggle/(:num)', 'SuperAdmin\Users::toggle/$1');
    $routes->post('users/reset-password/(:num)', 'SuperAdmin\Users::resetPassword/$1');
    $routes->post('users/delete/(:num)', 'SuperAdmin\Users::delete/$1');
    $routes->get('aktivitas', 'Admin\Activity::index');
});
