<?php


namespace mvc\Controllers;


use core\Db\Db;
use MVC\Models\Users\User;
use mvc\View\View;

/**
 * Class CoreController
 * @package mvc\Controllers
 */
abstract class CoreController
{
    protected View $view;
    protected User $user;

    public function __construct()
    {
        $this->view = new View();
    }
}