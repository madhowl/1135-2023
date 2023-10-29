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

    public function showIndexPage(array $articles)
    {
        return $this->view->render('blog-single', ['articles' => $articles]);
    }
    public function showSingleArticlePage(array $articles)
    {
        return $this->view->render('blog-single', ['articles' => $articles]);
    }


}