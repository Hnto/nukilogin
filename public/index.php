<?php

declare(strict_types=1);

/**
 * Set display error to true before determining environment
 */
ini_set('display_errors', '1');

/**
 * Set error_reporting to -1 to
 * report all php errors. We want to show them
 * to the user or log them properly
 */
ini_set('error_reporting', '-1');

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
*/
require __DIR__.'/../bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Require the application instantiation
|--------------------------------------------------------------------------
*/
require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run the application
|--------------------------------------------------------------------------
*/
$app->run();
