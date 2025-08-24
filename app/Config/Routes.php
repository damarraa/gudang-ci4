<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Categories
$routes->resource('categories', ['controller' => 'CategoriesController']);
// Products
$routes->resource('products', ['controller' => 'ProductsController']);
// Purchases
$routes->resource('purchases', ['controller' => 'PurchasesController']);
$routes->post('purchases/addItem', 'PurchasesController::addItem');
$routes->delete('purchases/deleteItem/(:num)', 'PurchasesController::deleteItem/$1');
// Incoming Items
$routes->get('incoming', 'IncomingController::index');
$routes->post('incoming/process/(:num)', 'IncomingController::process/$1');
// Outgoing Items
$routes->get('outgoing', 'OutgoingController::index');
$routes->post('outgoing', 'OutgoingController::create');
