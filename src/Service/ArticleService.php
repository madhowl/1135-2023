<?php


namespace App\Service;


use App\Core\Pagination;
use App\Model\ArticleModel;
use App\View\FrontView;

/**
 * Class ArticleService
 * @package App\Service
 */
class ArticleService implements ServiceInterface
{
 use Pagination;

    private ArticleModel $model;
    public FrontView $view;

    /**
     * ArticleService constructor.
     * @param ArticleModel $model
     * @param FrontView $view
     */
    public function __construct(ArticleModel $model, FrontView $view)
    {
        $this->model = $model;
        $this->view = $view;
    }


    /**
     * @inheritDoc
     */
    public function index($page = 1)
    {
        $count = $this->model->count();
        $this->totalRows = $count;
        $this->currentPage =$page;
        $offset = ($page-1)* $this->perPage;
        $articles = $this->model->paginate($this->perPage, $offset);
        $pagination = $this->createLinks();
        echo $this->view->showIndexPage($articles, $pagination);
    }

    /**
     * @inheritDoc
     */
    public function create()
    {
        // TODO: Implement create() method.
    }

    /**
     * @inheritDoc
     */
    public function store()
    {
        // TODO: Implement store() method.
    }

    /**
     * @inheritDoc
     */
    public function show(int $id)
    {
        $article = $this->model->find($id);
        echo $this->view->showSingleArticlePage($article);
    }

    /**
     * @inheritDoc
     */
    public function edit(int $id)
    {
        // TODO: Implement edit() method.
    }

    /**
     * @inheritDoc
     */
    public function update(int $id)
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public function destroy(int $id)
    {
        // TODO: Implement destroy() method.
    }
}