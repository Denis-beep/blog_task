<?php


use mvc\Controllers\MainController;

return [
        '~^$~' => [MainController::class, 'main'],
    '~^users/(\d+)$~' => [MainController::class, 'sayHello'],
    '~^users/(.*)$~' => [MainController::class, 'main'],
];