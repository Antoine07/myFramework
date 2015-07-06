<?php

namespace Controllers;

class BlogController extends BaseController
{

    /**
     * @return view
     */
    public function index()
    {
        $Post = $this->pdo->setObject('Models\\Post');
        $Post->id = 1;
        $Post->title = 'hello world';
        $Post->save();

        $posts = $Post->all();
        $title = 'Home page';

        return view('blog.index', compact('posts', 'title'));
    }

    /**
     * @param $id
     * @return view
     */
    public function show($id)
    {
        $Post = $this->pdo->setObject('Models\\Post');
        $post = $Post->find($id);
        $title = 'Single page';

        return $this->view->render('blog.single', compact('post', 'title'));
    }
}