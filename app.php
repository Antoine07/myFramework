<?php
/**
 * @author: Antoine07
 *
 * @description: framework
 */

/*
|--------------------------------------------------------------------------
| Auto loader
|--------------------------------------------------------------------------
|
| Auto loader Composer
|
*/

require_once __DIR__ . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Env
|--------------------------------------------------------------------------
|
| Configuration env
|
*/

use Dotenv\Dotenv;

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

/*
|--------------------------------------------------------------------------
| Constants
|--------------------------------------------------------------------------
|
*/

define('VIEW_PATH', __DIR__ . '/resources/views');
define('CACHE_PATH', __DIR__ . '/storage/cache');
define('ROUTES_PATH', __DIR__ . '/config');
define('LOGS_PATH', __DIR__ . '/storage/logs');
define('WEBSITE', getEnv('WEBSITE') ? getEnv('WEBSITE') : 'localhost/public');

/*
|--------------------------------------------------------------------------
| Application env
|--------------------------------------------------------------------------
|
*/

define('APPLICATION_ENV',
(getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'dev')
);

if (APPLICATION_ENV == 'production') {
    error_reporting(0);
} else {
    error_reporting(E_ALL);
}

/*
|--------------------------------------------------------------------------
| helpers
|--------------------------------------------------------------------------
|
*/

require_once __DIR__ . '/src/Services/Support/helper.php';


/*
|--------------------------------------------------------------------------
| Services
|--------------------------------------------------------------------------
|
| Services framework
|
*/

use Services\App;
use Services\Dispatcher;
use Services\Container\Container;
use Services\View\Engine;
use Services\View\View;
use Services\Router\Router;
use Services\Router\Route;
use Services\Request;

use Symfony\Component\Yaml\Yaml;

/*
|--------------------------------------------------------------------------
| Aliases
|--------------------------------------------------------------------------
|
| Aliases Facade
|
*/

/*
|--------------------------------------------------------------------------
| Container of Services configuration
|--------------------------------------------------------------------------
|
| Configuration services of framework
|
*/

$container = new Container;

$container['routes'] = Yaml::parse(ROUTES_PATH . '/routes.yaml');

$container['router'] = function ($c) {
    $router = new Router;
    foreach ($c['routes'] as $route) {
        $router->addRoute(new Route($route));
    }

    return $router;
};

$database = require_once __DIR__ . '/config/database.php';

$container['connection'] = $database['connections'][$database['default']];
$container['redis'] = new Predis\Client($database['connections']['redis']['default']);

/*
|--------------------------------------------------------------------------
| Engine template configuration
|--------------------------------------------------------------------------
|
| configuration template engine
|
*/

$container['viewPath'] = VIEW_PATH;
$container['cachePath'] = CACHE_PATH;

$container['engine'] = function ($c) {
    return new Engine;
};
$container['view'] = $container->asShared(function ($c) {
    return new View($c['viewPath'], $c['cachePath'], $c['engine']);
});

/*
|--------------------------------------------------------------------------
| App
|--------------------------------------------------------------------------
|
| Container
|
*/

App::set($container);

/*
|--------------------------------------------------------------------------
| Dispatcher
|--------------------------------------------------------------------------
|
| Simple framework dispatch
|
*/

$dispatcher = new Dispatcher(new Request);