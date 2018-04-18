<?php
$appDir = getcwd();

$extenderJsonFile = $appDir. '/settings/Extenders/extenders.json';
$extenderSkeletonFile = $appDir. '/build/format/Units/Skeleton/Extenders/skeleton';

$unit = $argv[1];

if (!is_dir($appDir. '/Units/' . $unit)) {
  exit(21);
}

$extender = $argv[2];

//=============>> BEGIN EXTENDERS JSON <<==================//
$extendersContent = file_get_contents($extenderJsonFile);
if ($extendersContent === false) {
    exit(23);
}

$extendersRoot = json_decode($extendersContent, true);
if (!isset($extendersRoot['Extenders']) || (!is_array($extendersRoot['Extenders']))) {
    exit(24);
}

$extenders = $extendersRoot['Extenders'];
if (isset($extenders[$unit])) {
    $newExtenders[$unit] = array_merge($extenders[$unit], ['Units\\' . $unit . '\\Extenders\\' . $extender . '']);
} else {
    $newExtenders[$unit] = ['Units\\' . $unit . '\\Extenders\\' . $extender . ''];
}

if (!is_writable($extenderJsonFile)) {
  exit(25);
}

$extendersJsonHandle = fopen($extenderJsonFile, 'w+');
ftruncate($extendersJsonHandle, 0);
fwrite($extendersJsonHandle, json_encode(['Extenders' => array_merge($extenders, $newExtenders)], JSON_PRETTY_PRINT));
//=============>> END EXTENDERS JSON <<==================//

//=============>> BEGIN PROVIDER FILE CREATION <<==================//
$extenderSkeletonContent = '<?php';
$extenderSkeletonContent .= file_get_contents($extenderSkeletonFile);
if ($extenderSkeletonContent === false) {
    exit(23);
}

$extenderContentChanges = ['{$unit}' => $unit, '{$extender}' => $extender];
$extenderSkeletonContent = strtr($extenderSkeletonContent, $extenderContentChanges);

$newExtenderHandle = fopen($appDir . '/Units/' . $unit . '/Extenders/' . $extender . '.php', 'w+');
fwrite($newExtenderHandle, $extenderSkeletonContent);
//=============>> END PROVIDER FILE CREATION <<==================//

fclose($extendersJsonHandle);
fclose($newExtenderHandle);