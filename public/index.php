<?php

use \app\core\Application;
use \app\controllers\SiteController;
use \app\controllers\AuthController;

require_once __DIR__ . '/../vendor/autoload.php';

$ROOT_DIR = dirname(__DIR__);

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

$app->router->get('/', [SiteController::class, 'index']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'handleContact']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->run();