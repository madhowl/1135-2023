<?php


namespace App\Controller;


use App\Core\Pagination;
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

    public function showArticlesPerPage($curentPage)
    {
        $page = $this->articleService->index($curentPage);
        echo $this->frontView->showIndexPage($page['articles'], $page['pagination']);
    }

    public function showArticleById(int $id)
    {
        $article = $this->articleService->show($id);
        echo $this->frontView->showSingleArticlePage($article);
    }
}