<?php

use Services\Router;

const BASE_PATH = __DIR__ . '/../';

require_once BASE_PATH . 'Services/Functions.php';

spl_autoload_register(function ($class) {
    require_once __DIR__ . '/../' . str_replace("\\", "/", $class) . '.php';
});


$router = new Router();
$router->loadConfig();
$router->handle();