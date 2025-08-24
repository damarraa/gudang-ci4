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
