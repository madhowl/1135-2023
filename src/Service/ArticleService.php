<?php


namespace App\Service;


use App\Core\Pagination;
use App\Model\ArticleModel;


/**
 * Class ArticleService
 * @package App\Service
 */
class ArticleService implements ServiceInterface
{
    use Pagination;

    private ArticleModel $model;

    /**
     * ArticleService constructor.
     * @param ArticleModel $model
     */
    public function __construct(ArticleModel $model)
    {
        $this->model = $model;
    }


    /**
     * @inheritDoc
     */
    public function index($currentPage = 1): array
    {
        $page = [];
        $count = $this->model->count();
        $this->totalRows = $count;
        $this->currentPage = $currentPage;
        $offset = ($currentPage - 1) * $this->perPage;
        $page['articles'] = $this->model->paginate($this->perPage, $offset);
        $page['pagination'] = $this->createLinks();
        return $page;
    }

    /**
     * @inheritDoc
     */
    public function create(array $properties): bool
    {
        $result = $this->model->insert($properties);
        if ($result){
            return true;
        }
        return false;
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
    public function show(int $id): array
    {
        return $this->model->find($id);
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