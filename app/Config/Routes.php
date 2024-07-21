<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Beneficiary::index');
$routes->post('search', 'Beneficiary::search');
$routes->post('comentarios', 'Beneficiary::comentarios');

$routes->get('login', 'Beneficiary::iniciar_sesion');
// $routes->post('admin/fetch_beneficiaries', 'Beneficiary::fetch_beneficiaries');
$routes->post('login', 'Beneficiary::login');
$routes->get('logout', 'Beneficiary::logout');
$routes->get('admin/delete', 'Beneficiary::deleteB');
$routes->get('admin/search', 'Beneficiary::searchL');
$routes->get('admin', 'Beneficiary::admin');
$routes->post('admin/store', 'Beneficiary::store');
$routes->post('admin/update', 'Beneficiary::update');
$routes->get('admin/edit/(:num)', 'Beneficiary::edit/$1');
$routes->post('admin/delete/(:num)', 'Beneficiary::delete/$1');
$routes->get('admin/comentario', 'Beneficiary::setComentarios');
$routes->post('comentarios/actualizar', 'Beneficiary::actualizar');

