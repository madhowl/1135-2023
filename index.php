<?php
declare(strict_types=1);
session_start();
require __DIR__ . '/vendor/autoload.php';

use FastRoute\RouteCollector;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAttributes(false);
$containerBuilder->addDefinitions('bootstrap/di.php');
$container = $containerBuilder->build();


$dispatcher = include_once 'bootstrap/routs.php';

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $error = $container->get(\App\Controller\BackController::class);
        $error->showError404Page();
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $route[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];

        // We could do $container->get($controller) but $container->call()
        // does that automatically
        $container->call($controller, $parameters);
        break;
}








//error_reporting(E_ALL);
//ini_set('display_errors', 'on');
//include_once 'function.php';
//
//
//
//include 'template/frontend/partials/head.php';
//include 'template/frontend/partials/breadcrumbs.php';
//include 'template/frontend/partials/blog-list.php';
//include 'template/frontend/partials/footer.php';
