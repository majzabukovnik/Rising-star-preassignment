<?php
use Controllers\IndexController;

return [
    '/homepage/' => [
        'GET' => [IndexController::class, 'index'],
        'POST' => [IndexController::class, 'processData']
    ]
];