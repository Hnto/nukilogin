<?php

/** @var \Nuki\Handlers\Http\Input\Request $requestHandler */
$requestHandler = $app->getService('request-handler');
$router = new \Nuki\Handlers\Http\Router($requestHandler);

/**
 * Here you can define you routes
 * The first param contains the URL
 * The second param can contain a callback function
 * or an array of the unit, service and process (no keys needed)
 */

$router->get('/', function () use ($app) {
    $app->getService('response-handler')->redirect('login');
});

$router->get('/register', ['System', 'Registration', 'form']);
$router->post('/register', ['System', 'Registration', 'process']);

$router->get('/login', ['System', 'Login', 'form']);
$router->post('/login', ['System', 'Login', 'process']);

$router->get('/account/home', ['System', 'Account', 'home']);
$router->get('/account/settings', ['System', 'Account', 'settings']);
$router->post('/account/settings', ['System', 'Account', 'save']);

$router->get('/account/logout', function () use ($app) {
   /** @var \Nuki\Handlers\Http\Session $sessionHandler */
   $sessionHandler = $app->getService('session-handler');
   /** @var \Nuki\Handlers\Http\Output\Response $responseHandler */
   $responseHandler = $app->getService('response-handler');

   $sessionHandler->destroy();

   $responseHandler->redirect('login');
});
