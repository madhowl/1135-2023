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

    public function showIndexPage(array $articles,$pagination =0)
    {
        return $this->view->render('blog-single', [
            'articles' => $articles,
            'pagination' =>$pagination
        ]);
    }
    public function showSingleArticlePage(array $articles)
    {
        return $this->view->render('blog-single', ['articles' => $articles]);
    }


}