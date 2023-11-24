<?php

declare(strict_types=1);


namespace App\Controller;


use App\Core\Auth;
use App\Helper as h;
use App\Service\ArticleService;
use App\Service\UserService;
use App\View\BackView;
use EdSDK\FlmngrServer\FlmngrServer;

class BackController
{
    use Auth;

    private ArticleService $articleService;
    private UserService $userService;
    private BackView $backView;

    /**
     * BackController constructor.
     *
     * @param  ArticleService  $articleService
     * @param  UserService  $userService
     * @param  BackView  $backView
     */
    public function __construct(
        ArticleService $articleService,
        UserService $userService,
        BackView $backView
    ) {
        $this->articleService = $articleService;
        $this->userService = $userService;
        $this->backView = $backView;
        if (!$this->checkAuth()) {
            $this->auth();
            exit;
        }
    }

    public function fileManager()
    {
        FlmngrServer::flmngrRequest(
            array(
                'dirFiles' => './img',
            )
        );
    }

    public function setPaginationParam()
    {
        $params = [
            'baseURL'       => '/admin/articles/page/',
            'firstLink'     => 'Первая',
            'nextLink'      => 'Следующая &raquo;',
            'prevLink'      => '&laquo; Предыдущая',
            'lastLink'      => 'Последняя',
            'aTagClass'     => 'class="page-link"',
            'fullTagOpen'   => '',
            'fullTagClose'  => '',
            'firstTagOpen'  => '<li class="page-item">',
            'firstTagClose' => '</li>',
            'lastTagOpen'   => '<li class="page-item">',
            'lastTagClose'  => '</li></ul>',
            'curTagOpen'    => '<li class="active">',
            'curTagClose'   => '</li>',
            'nextTagOpen'   => '<li class="page-item">',
            'nextTagClose'  => '</li>',
            'prevTagOpen'   => '<li class="page-item">',
            'prevTagClose'  => '</li>',
            'numTagOpen'    => '<li class="page-item">',
            'numTagClose'   => '</li>',
        ];

        $this->articleService->initialize($params);
    }

    public function auth()
    {
        if (!isset($_POST['btnLogin'])) {
            $this->showLoginForm();
            exit;
        } else {
            if ($this->checkLogin($_POST['username'], $_POST['password'])) {
                $this->signIn('admin', 1);
                $this->setMessage('Привет $username');
            }
            h::goUrl('/admin/');
        }
    }

    public function checkLogin(string $login, string $password): bool
    {
        if ($login == 'admin' and $password == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    public function logout()
    {
        $this->signOut();
        h::goUrl('/admin/');
    }

    public function showError404Page()
    {
        echo $this->backView->error404();
    }

    public function showDashboard()
    {
        $title = 'Панель управления';
        $message = $this->getMessage();
        echo $this->backView->index($title, $message);
    }

    public function showLoginForm()
    {
        echo $this->backView->showLoginForm();
    }


    public function setMessage(
        $message,
        $title = '',
        $color = 'green',
        $position = 'topRight'
    ) {
        $_SESSION['message'] = [
            'color'    => $color,
            'title'    => $title,
            'message'  => $message,
            'position' => $position,
        ];
    }

    public function getMessage()
    {
        $message = null;
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }

        return $message;
    }

    // --------- Articles --------

    public function showArticlesList($currentPage = 1)
    {
        $title = 'Список всех статей';
        $this->setPaginationParam();
        $page = $this->articleService->index($currentPage);
        $message = $this->getMessage();

        echo $this->backView->showArticlesList(
            $title,
            $page['articles'],
            $page['pagination'],
            $message
        );
    }

    public function showArticleCreateForm()
    {
        $title = 'Новая статья';
        $action = '/admin/article/create';
        $article = [
            'id'      => '',
            'title'   => '',
            'image'   => '',
            'content' => '',
        ];
        echo $this->backView->showArticleCreateForm($title, $action, $article);
    }

    public function createArticle()
    {
        $message = $this->articleService->create();
        $this->setMessage($message);
        h::goUrl('/admin/articles');
    }

    public function editArticle($id)
    {
        $id = (int)$id;
        $article = $this->articleService->edit($id);
        $title = 'Редактирование статьи';
        $action = '/admin/article/update';
        echo $this->backView->showArticleCreateForm($title, $action, $article);
    }

    public function updateArticle()
    {
        $message = $this->articleService->update();
        $this->setMessage($message);
        h::goUrl('/admin/articles');
    }

    public function deleteArticle($id)
    {
        $id = (int)$id;
        $message = $this->articleService->destroy($id);
        $this->setMessage($message);
        h::goUrl('/admin/articles');
    }

    //  ----------- Users ---------

    public function showUsersList($currentPage = 1)
    {
        $users = $this->userService->index($currentPage);
        $user = $this->getCurrentUser();
        $title = 'Список всех пользователей';
        $this->setPaginationParam();
        echo $this->backView->showUsersList(
            $title,
            $users['users'],
            $users['pagination']
        );
    }

    public function getCurrentUser(): array
    {
        return $this->userService->model->getCurentUser($_SESSION['user_id']);
    }
}