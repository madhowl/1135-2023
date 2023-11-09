<?php

use App\Controller\BackController;
use App\Controller\FrontController;
use App\Model\ArticleModel;
use App\Model\UserModel;
use App\Service\ArticleService;
use App\Service\UserService;
use App\View\BackView;
use App\View\FrontView;
use Jenssegers\Blade\Blade;
use Opis\Database\Connection;
use Opis\Database\Database;

use function DI\create;
use function DI\get;

return [
    'Connection' => create(Connection::class)
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
            get('Database')
        ),
    'UserModel' => create(UserModel::class)
        ->constructor(
            get('Database')
        ),
    'FrontBlade' => create(Blade::class)
        ->constructor(
            'template/frontend',
            'cache'
        ),
    'BackBlade' => create(Blade::class)
        ->constructor(
            'template/backend',
            'cache'
        ),
    'FrontView' => create(FrontView::class)
        ->constructor(
            get('FrontBlade')
        ),
    'BackView' => create(BackView::class)
        ->constructor(
            get('BackBlade')
        ),
    'ArticleService' => create(ArticleService::class)
        ->constructor(
            get('ArticleModel')
        ),
    'UserService' => create(UserService::class)
        ->constructor(
            get('UserModel')
        ),
    FrontController::class => create(FrontController::class)
        ->constructor(
            get('ArticleService'),
            get('FrontView')
        ),
    BackController::class => create(BackController::class)
        ->constructor(
            get('ArticleService'),
            get('UserService'),
            get('BackView')
        ),
];
