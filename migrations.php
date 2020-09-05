<?php

use \app\core\Application;

require_once __DIR__ . '/vendor/autoload.php';

$ROOT_DIR = __DIR__;

$dotenv = Dotenv\Dotenv::createImmutable($ROOT_DIR);
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
];

$app = new Application($ROOT_DIR, $config);

$app->database->applyMigrations();