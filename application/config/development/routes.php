<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Backend';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['dashboard'] = 'Backend';


// Akun Link
$route['akun'] = 'Regis';
$route['akun/data'] = 'Regis/get_data';
$route['akun/tambah'] = 'Regis/insert';
$route['akun/ubah/(:any)'] = 'Regis/put/$1';
$route['akun/put'] = 'Regis/update';
$route['akun/hapus/(:any)'] = 'Regis/destroy/$1';

// Anggota Link
$route['anggota'] = 'Anggota';
$route['anggota/data'] = 'Anggota/get_data';
$route['anggota/tambah'] = 'Anggota/insert';
$route['anggota/ubah/(:any)'] = 'Anggota/put/$1';
$route['anggota/put'] = 'Anggota/update';
$route['anggota/hapus/(:any)'] = 'Anggota/destroy/$1';

// Jabatan Link
$route['jabatan'] = 'Jabatan';
$route['jabatan/data'] = 'Jabatan/get_data';
$route['jabatan/tambah'] = 'Jabatan/insert';
$route['jabatan/ubah/(:any)'] = 'Jabatan/put/$1';
$route['jabatan/put'] = 'Jabatan/update';
$route['jabatan/hapus/(:any)'] = 'Jabatan/destroy/$1';

// Akunkas Link
$route['kodeakun'] = 'Akunkas';
$route['kodeakun/data'] = 'Akunkas/get_data';
$route['kodeakun/tambah'] = 'Akunkas/insert';
$route['kodeakun/ubah/(:any)'] = 'Akunkas/put/$1';
$route['kodeakun/put'] = 'Akunkas/update';
$route['kodeakun/hapus/(:any)'] = 'Akunkas/destroy/$1';

// Kasekluar Link
$route['kk'] = 'Kaskeluar';
$route['kk/data'] = 'Kaskeluar/get_data';
$route['kk/tambah'] = 'Kaskeluar/insert';
$route['kk/ubah/(:any)'] = 'Kaskeluar/put/$1';
$route['kk/put'] = 'Kaskeluar/update';
$route['kk/hapus/(:any)'] = 'Kaskeluar/destroy/$1';
$route['kk/kodeakun'] = 'Kaskeluar/kdakun';

// Kasekluar Link
$route['km'] = 'Kasmasuk';
$route['km/data'] = 'Kasmasuk/get_data';
$route['km/tambah'] = 'Kasmasuk/insert';
$route['km/ubah/(:any)'] = 'Kasmasuk/put/$1';
$route['km/put'] = 'Kasmasuk/update';
$route['km/hapus/(:any)'] = 'Kasmasuk/destroy/$1';
$route['km/kodeakun'] = 'Kasmasuk/kdakun';
