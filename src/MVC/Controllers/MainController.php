<?php

namespace MVC\Controllers;

class MainController
{
    public function main()
    {
        echo 'Главная страница';
    }

    public function sayHello(string $username)
    {
        echo 'Hello, ' . $username;
    }
}
