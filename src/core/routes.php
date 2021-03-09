<?php


use mvc\Controllers\MainController;
use mvc\Controllers\UsersController;

return [
        '~^$~' => [MainController::class, 'main'],
    '~^register$~' => [UsersController::class, 'register'],

];