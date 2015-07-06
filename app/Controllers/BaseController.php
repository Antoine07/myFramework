<?php

namespace Controllers;

use Models\Category;
use Services\Controller;

class BaseController extends Controller
{

    protected $layout = 'layouts.master';


    protected function init()
    {

        $category = $this->pdo->setObject('Models\\Category');
        $categories = $category->all();
        $this->view->setRender('partials.menu',compact('categories'));

        $this->view->setRender('layouts.partials.header', []);
        $this->view->setRender('layouts.partials.footer', []);
    }

}