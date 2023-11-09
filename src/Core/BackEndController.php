<?php

declare(strict_types=1);


namespace App;

use App\Helper as h;

class BackEndController
{
    private Model $model;
    private BackEndView $view;

    public function __construct()
    {
        $this->model = new Model();
        $this->view = new BackEndView();
        if (!isset($_SESSION['user'])) {
            $this->auth();
        }
    }

    public function auth()
    {
        if (!isset($_POST['btnLogin'])) {
            $this->showLoginForm();
            exit;
        } else {
            if ($this->checkLogin($_POST['username'], $_POST['password'])) {
                $_SESSION['user'] = 'admin';
                //echo 'Вы залогинелись';
            }
            h::goUrl('/admin');
        }
    }

    public function checkLogin(string $login, string $password): bool
    {
        if ($login == 'admin' and $password == '123') {
            return true;
        } else {
            return false;
        }
    }

    public function index()
    {
        $title = 'Список статей';
        $this->view->showIndex($title);
    }

    public function showLoginForm()
    {
        $this->view->showLoginForm();
    }

    public function logout()
    {
        session_destroy();
        h::goUrl('/admin');
    }

    public function articlesList()
    {
        $title = 'Список статей';
        $articles = $this->model->getArticles();
        $this->view->showArticlesList($title, $articles);
    }

    public function showArticleCreateForm()
    {
        $title = 'Добавление статьи';
        $article = [];
        $action = '/admin/article/create';
        $this->view->showArticleForm($title, $article, $action);
    }

    public function showArticleEditForm($id)
    {
        $title = 'Редактирование статьи';
        $article = $this->model->getArticleById((int)$id);
        $action = '/admin/article/update/';
        $this->view->showArticleForm($title, $article, $action);
    }

    public function articleDelete($id)
    {
        if ($this->model->articleDelete((int)$id)) {
            h::goUrl('/admin/articles');
            //return true;
        }
        //return false;
        h::goUrl('/admin/articles');
    }

    public function articleCreate()
    {
        $articleFields = $this->checkFields($_POST, $this->model->articleFields());
        $articles = $this->model->getArticles();
        $lastId = end($articles)['id'];
        $id = $lastId + 1;
        $articles[$id] = [
            'id' => $id,
            'title' => $articleFields['title'],
            'image' => $articleFields['image'],
            'content' => $articleFields['content']
        ];
        $this->model->saveArticles($articles);
        h::goUrl('/admin/articles');
    }

    public function checkFields(array $target, array $fields, bool $html = true): array
    {
        $checkedFields = [];
        foreach ($fields as $name) {
            if (isset($target[$name]) && $html == false) {
                $checkedFields[$name] = trim($target[$name]);
            } elseif (isset($target[$name]) && $html == true) {
                $checkedFields[$name] = htmlspecialchars(string: trim($target[$name]));
            }
        }
        return $checkedFields;
    }

    public function articleUpdate()
    {
        $articleItem = $this->checkFields($_POST, $this->model->articleFields());
        $articles = $this->model->getArticles();
        if (isset($articles[$articleItem['id']])) {
            $articles[$articleItem['id']] = [
                'id' => $articleItem['id'],
                'title' => $articleItem['title'],
                'image' => $articleItem['image'],
                'content' => $articleItem['content']
            ];
            $this->model->saveArticles($articles);
            //return true;
        }
        h::goUrl('/admin/articles');
    }
}