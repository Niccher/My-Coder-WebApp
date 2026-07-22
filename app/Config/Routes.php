<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Public landing pages
$routes->get('/', 'Landing::index');
$routes->get('/features', 'Landing::features');
$routes->get('/how-it-works', 'Landing::howItWorks');
$routes->get('/models', 'Landing::models');
$routes->get('/docker-setup', 'Landing::dockerSetup');
$routes->get('/faq', 'Landing::faq');
$routes->get('/chat', 'Chat::index', ['filter' => 'session']);
$routes->get('/c/(:segment)', 'Chat::index/$1', ['filter' => 'session']);

// API routes — all require session auth
$routes->group('api', ['filter' => 'session', 'namespace' => 'App\Controllers\Api'], static function ($routes) {
    $routes->post('chat', 'ChatController::send');

    $routes->get('settings', 'SettingsController::index');
    $routes->post('settings', 'SettingsController::save');

    $routes->get('conversations/paginated', 'ConversationsController::listPaginated');
    $routes->get('conversations', 'ConversationsController::index');
    $routes->get('conversations/(:segment)', 'ConversationsController::show/$1');
    $routes->post('conversations/(:num)/branch', 'ConversationsController::branch/$1');
    $routes->delete('conversations/(:num)', 'ConversationsController::delete/$1');

    $routes->get('personas', 'PersonasController::index');
    $routes->post('personas', 'PersonasController::save');
    $routes->delete('personas/(:num)', 'PersonasController::delete/$1');

    $routes->get('folders', 'FoldersController::index');
    $routes->post('folders', 'FoldersController::save');
    $routes->delete('folders/(:num)', 'FoldersController::delete/$1');
    $routes->post('user/profile', 'UserController::updateProfile');
    $routes->patch('conversations/(:num)/folder', 'ConversationsController::updateFolder/$1');
});

$routes->group('', ['namespace' => '\CodeIgniter\Shield\Controllers'], static function ($routes) {
    $routes->get('register', 'RegisterController::registerView', ['as' => 'register']);
    $routes->post('register', 'RegisterController::registerAction');
    
    $routes->get('login', 'LoginController::loginView', ['as' => 'login']);
    $routes->post('login', 'LoginController::loginAction');
    
    $routes->get('login/magic-link', 'MagicLinkController::loginView', ['as' => 'magic-link']);
    $routes->post('login/magic-link', 'MagicLinkController::loginAction');
    $routes->get('login/verify-magic-link', 'MagicLinkController::verify', ['as' => 'verify-magic-link']);
    
    $routes->get('logout', 'LoginController::logoutAction', ['as' => 'logout']);
    
    $routes->get('auth/a/show', 'ActionController::show', ['as' => 'auth-action-show']);
    $routes->post('auth/a/handle', 'ActionController::handle', ['as' => 'auth-action-handle']);
    $routes->post('auth/a/verify', 'ActionController::verify', ['as' => 'auth-action-verify']);
});

// Debug Routes for viewing Error Pages
$routes->group('debug', static function ($routes) {
    $routes->get('400', static fn() => view('errors/html/error_400', ['message' => 'Invalid parameters sent.']));
    $routes->get('401', static fn() => view('errors/html/error_401', ['message' => 'Session expired.']));
    $routes->get('403', static fn() => view('errors/html/error_403', ['message' => 'Access to this resource requires admin privileges.']));
    $routes->get('404', static fn() => view('errors/html/error_404', ['message' => 'The page you requested was not found.']));
    $routes->get('500', static fn() => view('errors/html/production', ['message' => 'Database connection failed.']));
    $routes->get('502', static fn() => view('errors/html/error_502', ['message' => 'Upstream server returned an invalid response.']));
    $routes->get('503', static fn() => view('errors/html/error_503', ['message' => 'Server is undergoing scheduled maintenance.']));
    $routes->get('4xx', static fn() => view('errors/html/error_4xx', ['message' => 'Generic client error.']));
    $routes->get('5xx', static fn() => view('errors/html/error_5xx', ['message' => 'Generic server error.']));
});

