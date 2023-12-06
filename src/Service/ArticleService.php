<?php

namespace App\Service;

use App\Core\Pagination;
use App\Interface\ServiceInterface;
use App\Model\ArticleModel;
use Exception;
use GUMP;

/**
 * Class ArticleService
 *
 * @package App\Service
 */
class ArticleService implements ServiceInterface
{
    use Pagination;

    private ArticleModel $model;

    /**
     * ArticleService constructor.
     *
     * @param  ArticleModel  $model
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
     * @throws Exception
     */
    public function create(): mixed
    {
        $message = null;
        $filtered = GUMP::filter_input($_POST, $this->model->filter);
        unset($filtered['id']);
        $is_valid = GUMP::is_valid($filtered, $this->model->rules);
        if ($is_valid === true) {
            if ($this->store($filtered) == null) {
                $message = 'Статья добавлена';
            }
        } else {
            $message = $is_valid; // array of error messages
        }

        return $message;
    }

    /**
     * @inheritDoc
     */
    public function store($properties)
    {
        return $this->model->insert($properties);
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
        return $this->model->find($id);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function update()
    {
        $message = null;
        $filtered = GUMP::filter_input($_POST, $this->model->filter);
        $id = (int)$filtered['id'];
        //dd($filtered);
        unset($filtered['id']);
        $is_valid = GUMP::is_valid($filtered, $this->model->rules);
        if ($is_valid === true) {
            if ($this->model->update($id, $filtered) == null) {
                $message = 'Статья изменена';
            }
        } else {
            $message = $is_valid; // array of error messages
        }

        return $message;
    }

    /**
     * @inheritDoc
     */
    public function destroy(int $id): string
    {
        $message = 'error';
        $m = $this->model->destroy($id);

        if ($m == true) {
            $message = 'Статья удалена';
        }

        return $message;
    }
}
