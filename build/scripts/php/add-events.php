<?php
$appDir = getcwd();

$servicesJsonFile = $appDir . '/settings/Services/services.json';
$eventSkeletonFile = $appDir . '/build/format/Units/Skeleton/Event/skeleton';

$unit = $argv[1];
if (!is_dir($appDir . '/Units/' . $unit)) {
  exit(21);
}

$service = $argv[2];
if (!file_exists($appDir . '/Units/' . $unit . '/Services/' . $service .'.php')) {
  exit(23);
}

$events = explode(',', $argv[3]);

if (!is_array($events)) {
  exit(24);
}

//=============>> BEGIN SERVICES JSON <<==================//
$servicesContent = file_get_contents($servicesJsonFile);
if ($servicesContent === false) {
    exit(24);
}

$servicesRoot = json_decode($servicesContent, true);
if (!isset($servicesRoot['Services']) || (!is_array($servicesRoot['Services']))) {
    exit(24);
}

$serviceEventsNew = [];
foreach($events as $event) {
  $serviceEventsNew[$event] = '\\Units\\' . $unit . '\\Events\\' . $event . '';
}

$serviceEventsCurrent = [];
if (is_array($servicesRoot['Services'][$service]['Events'])) {
  $serviceEventsCurrent = $servicesRoot['Services'][$service]['Events'];
}

$newEventsForService = array_merge($serviceEventsCurrent, $serviceEventsNew);
$servicesRoot['Services'][$service]['Events'] = $newEventsForService;

if (!is_writable($servicesJsonFile)) {
  exit(25);
}

$servicesJsonHandle = fopen($servicesJsonFile, 'w+');
ftruncate($servicesJsonHandle, 0);
fwrite($servicesJsonHandle, json_encode($servicesRoot, JSON_PRETTY_PRINT));
//=============>> END SERVICES JSON <<==================//

//=============>> BEGIN EVENT FILE CREATION <<==================//
foreach($events as $event) {
  $eventSkeletonContent = '<?php';
  $eventSkeletonContent .= file_get_contents($eventSkeletonFile);
  if ($eventSkeletonContent === false) {
      exit(24);
  }

  $eventContentChanges = ['{$unit}' => $unit, '{$event}' => $event];
  $eventSkeletonContent = strtr($eventSkeletonContent, $eventContentChanges);

  $newEventHandle = fopen($appDir . '/Units/' . $unit . '/Events/' . $event . '.php', 'w+');
  fwrite($newEventHandle, $eventSkeletonContent);
    fclose($newEventHandle);
}
//=============>> END EVENT FILE CREATION <<==================//

fclose($servicesJsonHandle);
