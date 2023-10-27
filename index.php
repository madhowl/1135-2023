<?php
declare(strict_types=1);
// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';
use FastRoute\RouteCollector;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
//use Tracy\Debugger;
//Debugger::enable();

use Opis\Database\Database;
use Opis\Database\Connection;
use Psr\Container\ContainerInterface;
use function DI\factory;

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->useAutowiring(true);
$containerBuilder->useAttributes(false);
//$containerBuilder->useAnnotations(false); //version PHP-DI < 7
$containerBuilder->addDefinitions('config/definitions.php');


$container = $containerBuilder->build();

//$app = $container->get (App\Controller::class);
//var_dump ($app->index());
// Define routes
//$router->get ('/', 'App\Controller@index');


//$container = require __DIR__ . '/../app/bootstrap.php';
//$container = require ('config/definitions.php');
$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controller','index']);
    $r->addRoute('GET', '/article/{id}', ['App\Controller', 'show']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

//$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
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
