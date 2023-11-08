<?php

use function DI\create;
use function DI\get;
use Jenssegers\Blade\Blade;
use Opis\Database\Connection;
use Opis\Database\Database;
use App\Model\ArticleModel;
use App\Controller\FrontController;
use App\View\FrontView;
use App\Service\ArticleService;



return [
    'Connection'=> create(Connection::class)
    ->constructor(
        $_ENV['DB_DSN'],
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD']
    ),
    'Database' => create(Database::class)
        ->constructor(
            get('Connection')
    ),
    'ArticleModel' => create(ArticleModel::class)
        ->constructor(
            get('Database'),
            'articles'
        ),
    'Blade'=>create(Blade::class)
        ->constructor(
            'template/frontend',
            'cache'
        ),
    'BackBlade'=>create(Blade::class)
        ->constructor(
            'template/backend',
            'cache'
        ),
    FrontController::class => create(FrontController::class)
        ->constructor(
            get('ArticleService')
        ),
    'FrontView' => create(FrontView::class)
        ->constructor(
            get('Blade')
        ),
    'ArticleService' => create(ArticleService::class)
        ->constructor(
            get('ArticleModel'),
            get('FrontView')
        ),
];
