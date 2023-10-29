<?php

use function DI\create;
use Opis\Database\Connection;



return [
    Opis\Database\Connection::class => \DI\create(Opis\Database\Connection::class)
    ->constructor(
        'mysql:host=localhost;dbname=cms-1135',
        'admin',
        'admin'
    ),
    Opis\Database\Database::class => \DI\create(Opis\Database\Database::class)
        ->constructor(
            DI\get(Opis\Database\Connection::class)
    ),
    'ArticleModel' => \DI\create(\App\Model\ArticleModel::class)
        ->constructor(
            DI\get(Opis\Database\Database::class),
            'articles'
        ),
    'Blade'=>create(Jenssegers\Blade\Blade::class)
    ->constructor('template/frontend' , 'cache'),
    App\Controller\FrontController::class => \DI\create(App\Controller\FrontController::class)
        ->constructor(DI\get('ArticleService')),
    'FrontView' => \DI\create(\App\View\FrontView::class)
        ->constructor(DI\get('Blade')),
    'ArticleService' => \DI\create(\App\Service\ArticleService::class)
        ->constructor(
            DI\get('ArticleModel')
            , DI\get('FrontView')
        ),
];
