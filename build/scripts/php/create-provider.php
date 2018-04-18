<?php
$appDir = getcwd();

$providerJsonFile = $appDir. '/settings/Providers/providers.json';
$providerSkeletonFile = $appDir. '/build/format/Units/Skeleton/Providers/skeleton';

$unit = $argv[1];

if (!is_dir($appDir. '/Units/' . $unit)) {
  exit(21);
}

$provider = $argv[2];

if (isset($argv[3])) {
  $type = $argv[2];
} else {
  $type = 'Database';
}

//=============>> BEGIN PROVIDERS JSON <<==================//
$providersContent = file_get_contents($providerJsonFile);
if ($providersContent === false) {
    exit(23);
}

$providersRoot = json_decode($providersContent, true);
if (!isset($providersRoot['Providers']) || (!is_array($providersRoot['Providers']))) {
    exit(24);
}

$providers = $providersRoot['Providers'];
$newProviders = array_merge($providers, [
    $provider => [
        'Location' => 'Units\\' . $unit . '\\Providers\\' . $provider . '',
        'Type' => 'Database',
        'Usage' => 'Units'
    ]
]);

if (!is_writable($providerJsonFile)) {
  exit(25);
}

$providersJsonHandle = fopen($providerJsonFile, 'w+');
ftruncate($providersJsonHandle, 0);
fwrite($providersJsonHandle, json_encode(['Providers' => $newProviders], JSON_PRETTY_PRINT));
//=============>> END PROVIDERS JSON <<==================//

//=============>> BEGIN PROVIDER FILE CREATION <<==================//
$providerSkeletonContent = '<?php';
$providerSkeletonContent .= file_get_contents($providerSkeletonFile);
if ($providerSkeletonContent === false) {
    exit(23);
}

$providerContentChanges = ['{$unit}' => $unit, '{$provider}' => $provider];
$providerSkeletonContent = strtr($providerSkeletonContent, $providerContentChanges);

$newProviderHandle = fopen($appDir . '/Units/' . $unit . '/Providers/' . $provider . '.php', 'w+');
fwrite($newProviderHandle, $providerSkeletonContent);
//=============>> END PROVIDER FILE CREATION <<==================//

fclose($providersJsonHandle);
fclose($newProviderHandle);