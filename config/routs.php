<?php
use Bramus\Router\Router;
// Create Router instance
$router = new Router();
// Define routes
$router->get ('/', 'App\Controller@index');

return $router;