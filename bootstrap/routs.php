<?php

use FastRoute\RouteCollector;

return FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controller\FrontController','showAllArticles']);
    $r->addRoute('GET', '/page/{page:\d+}', ['App\Controller\FrontController','showArticlesPerPage']);
    $r->addRoute('GET', '/article/{id}', ['App\Controller\FrontController', 'showArticleById']);
    $r->addRoute('GET', '/register', ['App\Controller\FrontController', 'showRegisterForm']);
    $r->addGroup('/admin', function (RouteCollector $r) {
        $r->addRoute('GET', '/', ['App\Controller\BackController', 'showDashboard']);
        $r->addRoute('POST', '/login', ['App\Controller\BackController', 'showDashboard']);
        $r->addRoute('GET', '/logout', ['App\Controller\BackController', 'logout']);

    });
});
