<?php

use App\Bootstrap\App;
use App\Configs\Config;
use App\Configs\Environment;
use App\Configs\Router;
use App\Controllers\ProductController;

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

define('VIEWS_PATH', __DIR__ . '/../views');

try {
    Environment::loadEnv(__DIR__ . '/../.env');
} catch (\Exception $e) {
    echo "Error loading environment variables: " . $e->getMessage();
    exit;
}

$router = new Router();
$router
    ->get('/', [ProductController::class, 'index'])
    ->post('/', [ProductController::class, 'delete'])
    ->get('/add-product', [ProductController::class, 'create'])
    ->post('/add-product', [ProductController::class, 'store']);

(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
))->run();
