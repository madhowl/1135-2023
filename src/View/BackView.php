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


}