<?php

namespace mvc\Controllers;

use core\Db\Db;
use mvc\View\View;
use mvc\Models\Articles\Article;

/**
 * Class MainController
 * @package mvc\Controllers
 */
class MainController
{

    /**
     * @var View
     */
    private View $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function main()
    {
        $articles = Article::findAll();
        $this->view->template('main/main', ['articles'=> $articles]);
    }
}
