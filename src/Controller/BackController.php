<?php

declare(strict_types=1);


namespace App\Controller;


use App\Core\Auth;
use App\Helper as h;
use App\Service\ArticleService;
use App\Service\UserService;
use App\View\BackView;

class BackController
{
    use Auth;
    private ArticleService $articleService;
    private UserService $userService;
    private BackView $backView;

    /**
     * BackController constructor.
     * @param ArticleService $articleService
     */
    public function __construct(
        ArticleService $articleService,
        UserService $userService,
        BackView $backView
    )
    {
        $this->articleService = $articleService;
        $this->userService = $userService;
        $this->backView = $backView;
        if (!$this->checkAuth()){
            $this->auth();
            exit;
        }
    }

    public function auth()
    {
        if (!isset($_POST['btnLogin'])) {
            $this->showLoginForm();
            exit;
        } else {
            if ($this->checkLogin($_POST['username'], $_POST['password'])) {
                $this->signIn('admin', 1);
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
        echo $this->backView->index($title);
    }

    public function showLoginForm()
    {
        echo $this->backView->showLoginForm();
    }

    public function showUsersList()
    {
        $users = $this->getAll('users');
        $user = $this->getCurentUser();
        $html = $this->View->showUserList($users, $user);
        return $this->responseWrapper($html);
    }
}