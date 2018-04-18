<?php
$appDir = getcwd();

$repositoryJsonFile = $appDir. '/settings/Repositories/repositories.json';
$repositorySkeletonFile = $appDir. '/build/format/Units/Skeleton/Repositories/skeleton';

$unit = $argv[1];

if (!is_dir($appDir. '/Units/' . $unit)) {
    exit(21);
}

$repository = $argv[2];
$providers = $argv[3];

//=============>> BEGIN REPOSITORY JSON <<==================//
$repositoryContent = file_get_contents($repositoryJsonFile);
if ($repositoryContent === false) {
    exit(23);
}

$repositoryRoot = json_decode($repositoryContent, true);
if (!isset($repositoryRoot['Repositories']) || (!is_array($repositoryRoot['Repositories']))) {
    exit(24);
}

$repositories = $repositoryRoot['Repositories'];
$newRepositories = array_merge($repositories, [
    $repository => [
        'Location' => 'Units\\' . $unit . '\\Repositories\\' . $repository . '',
        'Providers' => explode(',', $providers)
    ]
]);

if (!is_writable($repositoryJsonFile)) {
    exit(25);
}

$repositoryJsonHandle = fopen($repositoryJsonFile, 'w+');
ftruncate($repositoryJsonHandle, 0);
fwrite($repositoryJsonHandle, json_encode(['Repositories' => $newRepositories], JSON_PRETTY_PRINT));
//=============>> END REPOSITORIES JSON <<==================//

//=============>> BEGIN REPOSITORY FILE CREATION <<==================//
$repositorySkeletonContent = '<?php';
$repositorySkeletonContent .= file_get_contents($repositorySkeletonFile);
if ($repositorySkeletonContent === false) {
    exit(23);
}

$repositoryContentChanges = ['{$unit}' => $unit, '{$repository}' => $repository];
$repositorySkeletonContent = strtr($repositorySkeletonContent, $repositoryContentChanges);

$newRepositoryHandle = fopen($appDir . '/Units/' . $unit . '/Repositories/' . $repository . '.php', 'w+');
fwrite($newRepositoryHandle, $repositorySkeletonContent);
fclose($repositoryJsonHandle);
fclose($newRepositoryHandle);
