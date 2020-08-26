<?php

require_once __DIR__ . '/../vendor/autoload.php';
use \app\core\Application;
use \app\controllers\SiteController;
use \app\controllers\AuthController;

$ROOT_DIR = dirname(__DIR__);

$app = new Application($ROOT_DIR);

$app->router->get('/', [SiteController::class, 'index']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'handleContact']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'handleRegister']);

$app->run();