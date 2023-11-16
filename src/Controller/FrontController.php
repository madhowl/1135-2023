<?php


namespace App\Controller;


use App\Service\ArticleService;
use App\View\FrontView;

class FrontController
{

    private ArticleService $articleService;
    private FrontView $frontView;

    /**
     * FrontController constructor.
     */
    public function __construct(ArticleService $articleService, FrontView $frontView)
    {
        $this->articleService = $articleService;
        $this->frontView = $frontView;
    }

    public function showAllArticles()
    {
        $page = $this->articleService->index();
        echo $this->frontView->showIndexPage($page['articles'], $page['pagination']);

    }

    public function showArticlesPerPage($currentPage)
    {
        $page = $this->articleService->index($currentPage);
        echo $this->frontView->showIndexPage($page['articles'], $page['pagination']);
    }

    public function showArticleById($id)
    {
        $id =(int)$id;
        $article = $this->articleService->show($id);
        echo $this->frontView->showSingleArticlePage($article);
    }

    public function showRegisterForm()
    {
        echo $this->frontView->showRegisterForm();

    }
}