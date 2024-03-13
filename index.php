<?php

require_once 'read.env.php';
require_once 'config.php';
require_once 'utils.php';
require_once 'Router.php';

// ----- begin test area -----
// You can test some code before the loading of the router
require_once 'playground.php';

// ----- end test area -----


$router = new Router('controller');

if (getenv('DEBUG') == 1) {
    // Debug code (slow, generate every single route)
    // echo 'DEBUG MODE';
    $routes = $router->generateRoutes();
    // var_dump($routes);
    $router->saveRoutesToFile();
} else {
    // Production code (fast, load from file)
    // echo 'PRODUCTION MODE';
    $routes = $router->loadRoutesFromFile();
}

$request_uri = strtolower($_SERVER['REQUEST_URI']);
$base_name = strtolower(getenv('BASE_NAME'));
$page = str_replace($base_name, '', $request_uri);

// Extract query string from $page, and update $_GET
if (str_contains($page, '?')) {
    list($page, $query_string) = explode('?', $page, 2);
    parse_str($query_string, $_GET);
}

// Method is either GET or POST
// Route must exist and method must match (don't need to check GET)
if (
    isset($routes[$page]) &&
    (!isset($routes[$page]['http_method']) || $routes[$page]['http_method'] === $_SERVER['REQUEST_METHOD'])
) {
    require_once 'controller/functions/lang-cookie.php';
    require_once 'controller/functions/session.php';
    start_the_session();

    // Call the controller method
    $controller_name = $routes[$page]['controller'];
    $method_name = $routes[$page]['method'];
    require_once 'controller/' . $controller_name . '.php';

    $controller = new $controller_name();
    $controller->$method_name();
} else {
    // Handle case when route does not exist or method does not match
    var_dump('Requesting page: `' . htmlspecialchars($page) . '`');
    require_view('view/404.php');
}
