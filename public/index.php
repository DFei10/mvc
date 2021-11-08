<?php

use App\App;
use App\Config;
use App\Controllers\UsersController;
use App\QueryBuilder;
use App\Router;
use App\View;

include '../vendor/autoload.php';

define('VIEW_PATH', __DIR__ . '/../App/views/');
define('ROOT_PATH', dirname(__DIR__));

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

$router = new Router();

$router->get('/', function () {
    return View::make('home');
});

$router->get('/users', [UsersController::class, 'index']);
$router->get('/users/create', [UsersController::class, 'create']);
$router->post('/users', [UsersController::class, 'store']);

(new App(
    $router,
    new Config()
))->run();
