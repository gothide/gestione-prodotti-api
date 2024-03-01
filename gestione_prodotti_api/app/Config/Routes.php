<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'ProductsController::index');

$routes->group('prodotti', ['filter' => 'basicAuth'], function($routes) {
    $routes->get('', 'ProductsController::index');
    $routes->post('', 'ProductsController::create');
    $routes->get('(:num)', 'ProductsController::show/$1');
    $routes->put('(:num)', 'ProductsController::update/$1');
    $routes->delete('(:num)', 'ProductsController::delete/$1');
});
