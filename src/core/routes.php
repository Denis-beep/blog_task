<?php


use mvc\Controllers\MainController;
use mvc\Controllers\UsersController;

return [
    '~^users/register$~' => [UsersController::class, 'signUp'],
    '~^$~' => [MainController::class, 'main'],
];