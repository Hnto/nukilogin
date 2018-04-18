<?php
$driver = $argv[1];
$host = $argv[2];
$port = $argv[3];
$database = $argv[4];
$user = $argv[5];
$pass = isset($argv[6]) ? $argv[6] : '';

$dsn = $driver . ':' . 'host=' . $host . ':' . $port;

try {
    $dbh = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    exit(11);
}

$createDb = 'CREATE DATABASE IF NOT EXISTS `' . $database . '` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;';

$dbh->beginTransaction();
try {
  $dbh->exec($createDb);
  $dbh->commit();
} catch (Exception $e) {
  $dbh->rollBack();
  exit(12);
}

unset($dbh);
unset($dsn);

$dsn = $driver . ':dbname=' . $database . ';host=' . $host . ':' . $port;

try {
    $dbh = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    exit(11);
}

$connection = 'settings/Database/connection-pdo.json';

$connectionHandle = fopen($connection, 'w+');

$connectionContent = json_encode([
    'connection-info' => [
        'dsn' => $dsn, 
        'user' => $user, 
        'pass' => $pass,
        'options' => [
            '1002' => 'SET NAMES \'UTF8\'',
        ],
    ]
  ], JSON_PRETTY_PRINT
);

fwrite($connectionHandle, $connectionContent);

fclose($connectionHandle);
