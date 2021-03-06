<?php

namespace mvc\Controllers;

use core\Db\Db;
use mvc\View\View;
use mvc\Models\Articles\Article;

class MainController
{

    private View $view;

    private Db $db;

    public function __construct()
    {
        $this->view = new View();

        $this->db = Db::getInstance();
    }

    public function main()
    {
        $articles = Article::getById(1);
        $this->view->template('main/main', ['articles'=> $articles]);
    }
}
