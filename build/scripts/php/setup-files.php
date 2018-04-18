<?php
$appDir = getcwd() . '/';

$settingsDir = $appDir . 'settings';
$connectionDir = $appDir . 'settings/Database';
$providersDir = $appDir . 'settings/Providers';
$extendersDir = $appDir . 'settings/Extenders';

$repositoriesDir = $appDir . 'settings/Repositories';
$servicesDir = $appDir . 'settings/Services';
$renderingDir = $appDir . 'settings/Rendering';
$applicationDir = $appDir . 'settings/Application';
$configDir = $appDir . 'settings/Config';

$dirs = [$settingsDir, $connectionDir, $providersDir, $extendersDir, $repositoriesDir, $servicesDir, $renderingDir, $applicationDir, $configDir];

foreach($dirs as $dir) {
    if (!file_exists($dir)) {

        //Create the dir
        mkdir($dir, 0750);
    }
}

$connection = $appDir . 'settings/Database/connection-pdo.json';
$providers = $appDir . 'settings/Providers/providers.json';
$extenders = $appDir . 'settings/Extenders/extenders.json';

$repositories = $appDir . 'settings/Repositories/repositories.json';
$services = $appDir . 'settings/Services/services.json';
$rendering = $appDir . 'settings/Rendering/rendering.json';
$application = $appDir . 'settings/Application/app.env';
$config = $appDir . 'settings/Config/base.php';

$files = [$connection, $providers, $extenders, $repositories, $services, $rendering, $application, $config];

foreach($files as $file) {
    if (!file_exists($file)) {

        //Create the file
        touch($file);

        //Set correct permissions
        chmod($file, 0750);
    }
}

$connectionHandle = fopen($connection, 'w+');
$newConnectionContent = json_encode([
    'connection-info' => [
        'dsn' => '', 
        'user' => '', 
        'pass' => ''
    ]
  ], JSON_PRETTY_PRINT
);
fwrite($connectionHandle, $newConnectionContent);

$providersHandle = fopen($providers, 'w+');
$newProvidersContent = json_encode([
    'Providers' => [
    ],
  ], JSON_PRETTY_PRINT
);
fwrite($providersHandle, $newProvidersContent);

$extendersHandle = fopen($extenders, 'w+');
$newExtendersContent = json_encode([
    'Extenders' => [
    ],
], JSON_PRETTY_PRINT
);
fwrite($extendersHandle, $newExtendersContent);

$repositoriesHandle = fopen($repositories, 'w+');
$newRepositoriesContent = json_encode(['Repositories' => []], JSON_PRETTY_PRINT | JSON_FORCE_OBJECT);
fwrite($repositoriesHandle, $newRepositoriesContent);

$servicesHandle = fopen($services, 'w+');
$newServicesContent = json_encode(['Services' => []], JSON_PRETTY_PRINT | JSON_FORCE_OBJECT);
fwrite($servicesHandle, $newServicesContent);


$renderer = $argv[1];

switch($renderer) {
  case 'raw':
    $renderer = 'raw';
    break;
  
  case 'json':
    $renderer = 'json';
    break;
  
  case 'foil':
  default:
    $renderer = 'foil';
    break;
}

$renderingHandle = fopen($rendering, 'w+');
$newRenderingContent = json_encode([
    'default' => $renderer,
    'engines' => [
      'foil' => [
          'templating' => true,
          'folders' => [], 
          'options' => [
              'autoescape' => false,
              'alias' => 'Nuki',
          ],
      ],
      'raw' => [
        'templating' => false,
      ],
      'json' => [
        'templating' => false,
      ]
    ]
  ], JSON_PRETTY_PRINT | JSON_FORCE_OBJECT
);
fwrite($renderingHandle, $newRenderingContent);

$applicationHandle = fopen($application, 'w+');

# Application properties
//Generate random key
$appKey = bin2hex(random_bytes(20));
//Application name is set or default Nuki
$appName = isset($argv[2]) ? $argv[2] : '';
//Application storage driver
$appStorage = isset($argv[3]) ? $argv[3] : '';
//Application environment
$appEnv = isset($argv[4]) ? $argv[4] : 'DEVELOPMENT';

$applicationContent = 'APP_KEY="' . $appKey . '"
APP_NAME="' . $appName . '"
APP_STORAGEDRIVER="' . $appStorage . '"
APP_ENV="' . $appEnv . '"
APP_ALGORITHM="sha512"';

fwrite($applicationHandle, $applicationContent);

$configHandle = fopen($config, 'w+');

$configContent = '
<?php

/**
 * Here you can add as many configuration values
 * you like. They will be available in the Config handler.
 * This handler can be found in the container
 */
return [
];

';

fwrite($configHandle, $configContent);

fclose($connectionHandle);
fclose($providersHandle);
fclose($repositoriesHandle);
fclose($servicesHandle);
fclose($renderingHandle);
fclose($applicationHandle);
fclose($configHandle);
