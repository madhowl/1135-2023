<?php

use FastRoute\RouteCollector;

return FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controller\FrontController','showAllArticles']);
    $r->addRoute('GET', '/page/{curentPage:\d+}', ['App\Controller\FrontController','showArticlesPerPage']);
    $r->addRoute('GET', '/article/{id}', ['App\Controller\FrontController', 'showArticleById']);
    $r->addRoute('GET', '/register', ['App\Controller\FrontController', 'showRegisterForm']);
    $r->addGroup('/admin', function (RouteCollector $r) {
        $r->addRoute('GET', '/', ['App\Controller\BackController', 'showDashboard']);
        $r->addRoute('POST', '/login', ['App\Controller\BackController', 'showDashboard']);
        $r->addRoute('GET', '/logout', ['App\Controller\BackController', 'logout']);
        $r->addRoute('GET', '/articles', ['App\Controller\BackController', 'showArticlesList']);
        $r->addRoute('GET', '/articles/page/{curentPage:\d+}', ['App\Controller\BackController', 'showArticlesList']);
        $r->addRoute('GET', '/article/create', ['App\Controller\BackController', 'showArticleCreateForm']);

    });
});
