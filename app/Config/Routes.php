<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/sign-up', 'AuthController::signUp');
$routes->get('/sign-in', 'AuthController::signIn');