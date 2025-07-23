<?php

use App\Controllers\CitoyensController;

return [
    '/' => [
        'controller' => CitoyensController::class,
        'method' => 'index', 
        'methods' => ['GET'],
    ],
    '/citoyens' => [
        'controller' => CitoyensController::class,
        'method' => 'index',
        'methods' => ['GET'],
    ],
    'citoyens/{nci}' => [  
        'controller' => CitoyensController::class,
        'method' => 'findByNci',
        'methods' => ['GET'],
    ],
];
