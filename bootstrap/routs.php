<?php

use FastRoute\RouteCollector;

return FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controller\FrontController','showAllArticles']);
    $r->addRoute('GET', '/page/{currentPage:\d+}', ['App\Controller\FrontController','showArticlesPerPage']);
    $r->addRoute('GET', '/article/{id}', ['App\Controller\FrontController', 'showArticleById']);
    $r->addRoute('GET', '/register', ['App\Controller\FrontController', 'showRegisterForm']);
    $r->addGroup('/admin', function (RouteCollector $r) {

        $r->addRoute('GET', '/filemanager', ['App\Controller\BackController', 'filemanager']);
        $r->addRoute('POST', '/filemanager', ['App\Controller\BackController', 'filemanager']);

        $r->addRoute('GET', '/', ['App\Controller\BackController', 'showDashboard']);
        $r->addRoute('POST', '/login', ['App\Controller\BackController', 'showDashboard']);
        $r->addRoute('GET', '/logout', ['App\Controller\BackController', 'logout']);
        //
        // -----  Articles ------
        //
        $r->addRoute('GET', '/articles', ['App\Controller\BackController', 'showArticlesList']);
        $r->addRoute('GET', '/articles/page/{currentPage:\d+}', ['App\Controller\BackController', 'showArticlesList']);
        $r->addRoute('GET', '/article/create', ['App\Controller\BackController', 'showArticleCreateForm']);
        $r->addRoute('POST', '/article/create', ['App\Controller\BackController', 'createArticle']);
        $r->addRoute('GET', '/article/edit/{id}', ['App\Controller\BackController', 'editArticle']);
        $r->addRoute('POST', '/article/update', ['App\Controller\BackController', 'updateArticle']);
        $r->addRoute('GET', '/article/delete/{id}', ['App\Controller\BackController', 'deleteArticle']);
        //
        // -----  Users ------
        //
        $r->addRoute('GET', '/users', ['App\Controller\BackController', 'showUsersList']);
        $r->addRoute('GET', '/users/page/{currentPage:\d+}', ['App\Controller\BackController', 'showUsersList']);

    });
});
