<?php
use Dotenv\Dotenv;

if(file_exists(__DIR__ . '/vendor/autoload.php'))
{
    include __DIR__ . '/vendor/autoload.php';

    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

if($_ENV['app_debug'] == true)
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}


// Autoloader
spl_autoload_register(
    fn (string $filename) => include 'src/' .  str_replace('\\', '/', $filename) . '.php'
);

// Got route without slash
$route = substr($_SERVER['REQUEST_URI'], 1) ?? '';
$routes = require __DIR__ . '/src/core/routes.php';

$isRouteFound = false;

// Cycle to match routes
foreach($routes as $routePattern => $routeCallback)
{
    preg_match($routePattern, $route, $matches);
    if($matches){
        $isRouteFound = true;
        break;
    }
}

if(!$isRouteFound)
{
    $response = [
        'html' => ''
    ];
    $response['html'] .= '<p>Страница не была найдена</p>';
    $response['html'] .= '<a class="" href="#" onclick="window.history.back()">Назад</a>';
    echo $response['html'];
    return;
}

// Unset matched controller to keep route params
unset($matches[0]);

// Route callback
$controller = $routeCallback[0];
$method = $routeCallback[1];

$controller = new $controller();
$controller->$method(...$matches);
