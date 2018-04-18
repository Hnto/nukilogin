<?php
$renderingJsonFile = getcwd() . '/settings/Rendering/rendering.json';

$appDir = getcwd();

$unit = $argv[1];

if (!is_dir(getcwd() . '/Units')) {
    exit(21);
}

//=============>> BEGIN SERVICES JSON <<==================//
$renderingContent = file_get_contents($renderingJsonFile);
if ($renderingContent === false) {
    exit(23);
}

$renderingRoot = json_decode($renderingContent, true);
if (!isset($renderingRoot['default']) || 
   (!isset($renderingRoot['engines']) && !is_array($renderingRoot['engines']))) {
    exit(24);
}

$default = $renderingRoot['default'];
if (strtolower($default) === 'html') {
  exit(0);
}

if (!isset($renderingRoot['engines'][$default]) || (!is_array($renderingRoot['engines'][$default]))) {
  exit(24);
}

if ($renderingRoot['engines'][$default]['templating'] !== true) {
  exit(0);
}

if (!isset($renderingRoot['engines'][$default]['folders'])) {
  exit(24);
}

if (!is_writable($renderingJsonFile)) {
  exit(25);
}

$newFolders = array_merge(
  $renderingRoot['engines'][$default]['folders'], 
  [$unit => $appDir . '/Units/' . $unit . '/Templates']
);

$renderingRoot['engines'][$default]['folders'] = $newFolders;

$renderingJsonHandle = fopen($renderingJsonFile, 'w+');
ftruncate($renderingJsonHandle, 0);
fwrite($renderingJsonHandle, json_encode($renderingRoot, JSON_PRETTY_PRINT));
//=============>> END SERVICES JSON <<==================//

fclose($renderingJsonHandle);
