<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'ProductsController::index');

$routes->group('prodotti', ['filter' => 'basicAuth'], function($routes) {
    $routes->get('', 'ProductsController::index');
    $routes->post('', 'ProductsController::create');
    $routes->get('(:num)', 'ProductsController::show');
    $routes->delete('delete/(:num)', 'ProductsController::delete/$1');
    $routes->get('edit/(:num)', 'ProductsController::edit/$1');
    $routes->post('update/(:num)', 'ProductsController::update/$1');
});
