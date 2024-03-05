<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/sign-up', 'AuthController::signUp');
$routes->get('/sign-in', 'AuthController::signIn');
$routes->post('/register-user', 'AuthController::registerUser');
$routes->post('/login', 'AuthController::login');

$routes->get('/home', 'TweetsController::retrieveTweets');