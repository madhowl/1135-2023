<?php

declare(strict_types=1);


namespace App\View;


use Jenssegers\Blade\Blade;

class BackView
{
    public Blade $view;

    /**
     * FrontView constructor.
     * @param Blade $view
     */
    public function __construct(Blade $view)
    {
        $this->view = $view;
    }

    public function index($title, $message): string
    {
        return $this->view->render('dashboard',['title'=>$title, 'message'=>$message]);
    }

    public function showLoginForm(): string
    {
        return $this->view->render('login');
    }

    public function error404(): string
    {
        return $this->view->render('pages-error-404');
    }

    public function showArticlesList($title, mixed $articles, mixed $pagination)
    {
       return $this->view->render('articles-list', [
           'title'=>$title,
            'articles' => $articles,
            'pagination' =>$pagination,
           'message'=>[]
        ]);
    }

    public function showArticleCreateForm($title, $action, $article)
    {
        return $this->view->render('article-form', [
            'title'=>$title,
            'article' => $article,
            'action' =>$action
        ]);

    }


}