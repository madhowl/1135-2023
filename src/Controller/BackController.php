<?php

declare(strict_types=1);


namespace App\Controller;


use App\Service\ArticleService;
use App\Service\UserService;
use App\View\BackView;

class BackController
{
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
    ) {
        $this->articleService = $articleService;
        $this->userService = $userService;
        $this->backView = $backView;
    }

    public function showDashboard()
    {
        return $this->View->index();
    }

    public function showSignInForm()
    {
        $message = $this->getMessage();
        $html = $this->View->showSignInForm($message);
        return $this->responseWrapper($html);
    }

    public function showSignUpForm()
    {
        $html = $this->View->showSignUpForm();
        return $this->responseWrapper($html);
    }

    public function showUsersList()
    {
        $users = $this->getAll('users');
        $user = $this->getCurentUser();
        $html = $this->View->showUserList($users, $user);
        return $this->responseWrapper($html);
    }
}