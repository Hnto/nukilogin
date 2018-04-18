<?php
$appDir = getcwd();

$servicesJsonFile = $appDir . '/settings/Services/services.json';
$serviceSkeletonFile = $appDir . '/build/format/Units/Skeleton/Service/skeleton';

$unit = $argv[1];

if (!is_dir($appDir . '/Units/' . $unit)) {
  exit(21);
}

$service = $argv[2];
$process = $argv[3];

//=============>> BEGIN SERVICES JSON <<==================//
$servicesContent = file_get_contents($servicesJsonFile);
if ($servicesContent === false) {
    exit(23);
}

$servicesRoot = json_decode($servicesContent, true);
if (!isset($servicesRoot['Services']) || (!is_array($servicesRoot['Services']))) {
    exit(24);
}

$services = $servicesRoot['Services'];
$newServices = array_merge($services, [
    $service => [
        'Events' => '',
        'Extenders' => '',
    ],
]);

if (!is_writable($servicesJsonFile)) {
  exit(25);
}

$servicesJsonHandle = fopen($servicesJsonFile, 'w+');
ftruncate($servicesJsonHandle, 0);
fwrite($servicesJsonHandle, json_encode(['Services' => $newServices], JSON_PRETTY_PRINT));
//=============>> END SERVICES JSON <<==================//

//=============>> BEGIN SERVICE FILE CREATION <<==================//
$serviceSkeletonContent = '<?php';
$serviceSkeletonContent .= file_get_contents($serviceSkeletonFile);
if ($serviceSkeletonContent === false) {
    exit(23);
}

$serviceContentChanges = [
    '{$unit}' => $unit, 
    '{$service}' => $service, 
    '{$process}' => $process
];
$serviceSkeletonContent = strtr($serviceSkeletonContent, $serviceContentChanges);

$newServiceHandle = fopen($appDir . '/Units/' . $unit . '/Services/' . $service . '.php', 'w+');
fwrite($newServiceHandle, $serviceSkeletonContent);
//=============>> END SERVICE FILE CREATION <<==================//

fclose($servicesJsonHandle);
fclose($newServiceHandle);
