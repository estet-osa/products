<?php

/** Require autoload PSR-4 */
require dirname(__DIR__) . '/vendor/autoload.php';

/** @var Object $router */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'ProductsController',  'action' => 'index']);
$router->add('products/list', ['controller' => 'ProductsController', 'action' => 'list']);
$router->add('products/del',  ['controller' => 'ProductsController', 'action' => 'del']);

$router->dispatch(substr($_SERVER['REQUEST_URI'], 1));
