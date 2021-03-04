<?php
return [
        '~^$~' => [\MVC\Controllers\MainController::class, 'main'],
    '~^users/(\d+)$~' => [\MVC\Controllers\MainController::class, 'sayHello'],
    '~^users/(.*)$~' => [\MVC\Controllers\MainController::class, 'main'],
];