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
$routes->get('/logout', 'AuthController::logout');
$routes->get('/twoFactor', 'AuthController::twoFactor');

$routes->get('/home', 'TweetsController::retrieveTweets', ['filter' => 'auth']);
$routes->get('/add', 'TweetsController::addTweet', ['filter' => 'auth']);
$routes->post('/addPost', 'TweetsController::AddPost', ['filter' => 'auth']);
$routes->post('/removePost', 'TweetsController::removePost', ['filter' => 'auth']);
$routes->post('/editPost', 'TweetsController::editPostView', ['filter' => 'auth']);
$routes->post('/editData', 'TweetsController::editPost', ['filter' => 'auth']);
$routes->get('/piw/(:any)', 'TweetsController::view/$1', ['filter' => 'auth']);
$routes->post('/download', 'TweetsController::download', ['filter' => 'auth']);

$routes->presenter('api');
$routes->get('/getPiws', 'ApiController::index');
$routes->get('/getPiw/(:any)', 'ApiController::show/$1');
$routes->post('/addPiew', 'ApiController::create');
$routes->put('/updatePiew/(:any)', 'ApiController::update/$1');