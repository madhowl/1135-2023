<?php


namespace App\View;


use Jenssegers\Blade\Blade;

class FrontView
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

    public function showIndexPage(array $articles, $pagination = 0): string
    {
        return $this->view->render('blog', [
            'articles' => $articles,
            'pagination' =>$pagination
        ]);
    }

    public function showSingleArticlePage(array $article): string
    {
        return $this->view->render('blog-single', ['article' => $article]);
    }

    public function showRegisterForm(): string
    {
        return $this->view->render('register');
    }


}