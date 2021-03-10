<?php

namespace mvc\Controllers;

use core\Db\Db;
use mvc\Models\Users\User;
use mvc\View\View;
use mvc\Models\Articles\Article;

/**
 * Class MainController
 * @package mvc\Controllers
 */
class MainController extends CoreController
{

    /**
     * A blog main page.
     */
    public function main()
    {
        $articles = User::findAll();
        $this->view->template('main/main', ['articles'=> $articles]);
    }
}
