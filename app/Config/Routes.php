<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/sign-up', 'AuthController::signUp');
$routes->get('/sign-in', 'AuthController::signIn');
$routes->post('/register-user', 'AuthController::registerUser');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/twoFactor', 'AuthController::twoFactor');
$routes->post('/activate2fa', 'AuthController::add2fa_post', ['filter' => 'auth']);
$routes->get('/twoFactorConfirm', 'AuthController::twoFactorConfirm');
$routes->post('/tryTwoFactor', 'AuthController::twoFactorConfirmPost');
$routes->get('/urlView', 'AuthController::urlVerification');
$routes->post('/updateUrl', 'AuthController::updateUrlVerification', ['filter' => 'auth']);

$routes->get('/', 'TweetsController::retrieveTweets', ['filter' => 'auth']);
$routes->get('/home', 'TweetsController::retrieveTweets', ['filter' => 'auth']);
$routes->get('/add', 'TweetsController::addTweet', ['filter' => 'auth']);
$routes->post('/addPost', 'TweetsController::AddPost', ['filter' => 'auth']);
$routes->post('/removePost', 'TweetsController::removePost', ['filter' => 'auth']);
$routes->post('/editPost', 'TweetsController::editPostView', ['filter' => 'auth']);
$routes->post('/editData', 'TweetsController::editPost', ['filter' => 'auth']);
$routes->get('/piw/(:any)', 'TweetsController::view/$1', ['filter' => 'auth']);
$routes->post('/download', 'TweetsController::download', ['filter' => 'auth']);
$routes->get('/piws/(:any)', 'TweetsController::viewUserPosts/$1');
$routes->get('no-validate-posts', 'TweetsController::noValidatePosts');