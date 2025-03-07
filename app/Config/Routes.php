<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

    $routes->get('/', 'App\Controllers\ProductController::index');
    $routes->get('/dashboard', 'dashboardController::index');

    $routes->get('/products', 'productController::index');
    $routes->get('product/search', 'ProductController::search');


    $routes->get('/index', 'productController::index');         // Menampilkan daftar produk
    $routes->get('create', 'productController::create');   // Form untuk menambah produk baru
    $routes->post('products/store', 'productController::store');    // Menyimpan data produk baru

    $routes->post('products/update/(:num)', 'ProductController::update/$1');  //mengedit

    $routes->post('products/delete/(:num)', 'ProductController::delete/$1'); //menghapus

    

;


