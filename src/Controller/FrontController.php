<?php


namespace App\Controller;


use App\Service\ArticleService;

class FrontController
{
    private ArticleService $articleService;

    /**
     * FrontController constructor.
     */
    public function __construct(ArticleService $service)
    {
        $this->articleService = $service;
    }

    public function showAllArticles()
    {
        $this->articleService->index();
    }

    public function showArticlesPerPage($page)
    {
        $this->articleService->index($page);
    }

    public function showArticleById(int $id)
    {
        $this->articleService->show($id);
    }
}