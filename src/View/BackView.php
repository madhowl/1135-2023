<?php

declare(strict_types=1);


namespace App\View;


use Jenssegers\Blade\Blade;

class BackView
{
    public Blade $view;

    /**
     * FrontView constructor.
     * @param Blade $view
     */
    public function __construct(Blade $view)
    {
        $this->view = $view;
    }

    public function index($title): string
    {
        return $this->view->render('dashboard',['title'=>$title]);
    }

    public function showLoginForm(): string
    {
        return $this->view->render('login');
    }

    public function error404(): string
    {
        return $this->view->render('pages-error-404');
    }


}