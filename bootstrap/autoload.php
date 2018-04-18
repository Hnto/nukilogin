<?php

$composerAutoloader = __DIR__.'/../vendor/autoload.php';

if (!file_exists($composerAutoloader)) {
  echo 'Autoloader could not be found. The Nuki framework has not been configured correctly';
  exit;
}

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
*/
require_once $composerAutoloader;
