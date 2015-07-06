<?php

use Services\Router\Router;
use Services\Router\Route;
use Symfony\Component\Yaml\Yaml;

/**
 * Tests routing
 *
 * @author antoine
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{

    protected $router;
    protected $urls;

    public function setUp()
    {
        $this->router = new Router;
        $this->urls = Yaml::parse(__DIR__ . '/Fixtures/urls.yml');
    }

    public function assertPreConditions()
    {
        $this->assertEquals(0, count($this->router));
    }

    /**
     * @test count routes
     */
    public function testAddRoutes()
    {
        $routes = Yaml::parse(__DIR__ . '/Fixtures/routes.yml');

        foreach ($routes as $route) {
            $this->router->addRoute(new Route($route));
        }
        $this->assertEquals(5, count($this->router));
    }

    /**
     * @test same route exception RuntimeException
     */
    public function testSameRouteStorage()
    {
        $routes = Yaml::parse(__DIR__ . '/Fixtures/routes.yml');
        foreach ($routes as $route) {
            $this->router->addRoute(new Route($route));
        }

        $this->assertEquals(5, count($this->router));

        $route2 = Yaml::parse(__DIR__ . '/Fixtures/routes2.yml');

        $this->setExpectedException('RuntimeException', 'Cannot override route "Controllers\BlogController:index".');
        $this->router->addRoute(new Route($route2['BlogController_index']));
    }

    /**
     * @test bad syntax route
     */
    public function testBadConnectRouteYml()
    {
        $routes = Yaml::parse(__DIR__ . '/Fixtures/bad.yml');
        $this->setExpectedException('RuntimeException', 'Bad syntax connect');
        $this->router->addRoute(new Route($routes['BlogController_index']));
    }

    /**
     * @test
     */
    public function testNoParamsReturnNull()
    {
        $routes = Yaml::parse(__DIR__ . '/Fixtures/noparam.yml');
        $this->router->addRoute(new Route($routes['BlogController_index']));
        $r = $this->router->getRoute('/', 'GET');
        $this->assertEquals($r->getParams(), NULL);
    }

    /**
     * @test
     */
    public function testGetterControllerActionParams()
    {
        $route = Yaml::parse(__DIR__ . '/Fixtures/routes.yml');
        $this->router->addRoute(new Route($route['BlogController_show']));
        $this->router->addRoute(new Route($route['BlogController_index']));
        $this->router->addRoute(new Route($route['CategoryController_show']));

        $r = $this->router->getRoute('/php-tour-2015/2', 'GET');
        $this->assertEquals('Controllers\BlogController', $r->getController());
        $this->assertEquals('show', $r->getAction());
        $this->assertEquals([ 2], $r->getParams());

        $r = $this->router->getRoute('/vagrant-vm-tour/100');
        $this->assertEquals('Controllers\BlogController', $r->getController());
        $this->assertEquals('show', $r->getAction());
        $this->assertEquals([100], $r->getParams());

        $r = $this->router->getRoute('/le-Tour-Symfony2/21');
        $this->assertEquals('Controllers\BlogController', $r->getController());
        $this->assertEquals('show', $r->getAction());
        $this->assertEquals([ 21], $r->getParams());

        $r = $this->router->getRoute('/');
        $this->assertEquals('Controllers\BlogController', $r->getController());
        $this->assertEquals('index', $r->getAction());
        $this->assertEquals(NULL, $r->getParams());

        // category slug test
        $r = $this->router->getRoute('/cat/php/21/1');
        $this->assertEquals('Controllers\CategoryController', $r->getController());
        $this->assertEquals('show', $r->getAction());
        $this->assertEquals([ 21, 1], $r->getParams());
    }


    /**
     * @test all actions rest
     */
     public function testApiRestAllActions()
     {
         $routes = Yaml::parse(__DIR__ . '/Fixtures/rest.yml');
         foreach ($routes as $route) {
             $r = new Route($route);
         }

         $this->assertEquals($r->getGuardedRestAction(), ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
     }

    /**
     * @test guarded action REST
     */
     public function testApiRestActions()
     {
         $routes = Yaml::parse(__DIR__ . '/Fixtures/rest.yml');
         foreach ($routes as $route) {
             $r = new Route($route);
         }

         $this->assertEquals($r->getGuardedRestAction(), ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
     }

    /**
     * @test rest route API all methods
     */
    public function testRESTFul()
    {
        $route = Yaml::parse(__DIR__ . '/Fixtures/rest.yml');
        $this->router->addRoute(new Route($route['PostController']));

        $r = $this->router->getRoute('/post', 'GET');
        $this->assertEquals('Controllers\PostController', $r->getController());
        $this->assertEquals('index', $r->getAction());
        $this->assertEquals('GET', $r->getVerb());

        $r = $this->router->getRoute('/post/create', 'GET');
        $this->assertEquals('Controllers\PostController', $r->getController());
        $this->assertEquals('create', $r->getAction());
        $this->assertEquals('GET', $r->getVerb());

        $r = $this->router->getRoute('/post', 'POST');
        $this->assertEquals('Controllers\PostController', $r->getController());
        $this->assertEquals('store', $r->getAction());
        $this->assertEquals('POST', $r->getVerb());

        $r = $this->router->getRoute('/post/23', 'GET');
        $this->assertEquals('Controllers\PostController', $r->getController());
        $this->assertEquals('show', $r->getAction());
        $this->assertEquals('GET', $r->getVerb());

        $r = $this->router->getRoute('/post/23/edit', 'GET');
        $this->assertEquals('Controllers\PostController', $r->getController());
        $this->assertEquals('edit', $r->getAction());
        $this->assertEquals('GET', $r->getVerb());

        $r = $this->router->getRoute('/post/23', 'PUT');
        $this->assertEquals('Controllers\PostController', $r->getController());
        $this->assertEquals('update', $r->getAction());
        $this->assertEquals('PUT', $r->getVerb());

        $r = $this->router->getRoute('/post/23', 'DELETE');
        $this->assertEquals('Controllers\PostController', $r->getController());
        $this->assertEquals('destroy', $r->getAction());
        $this->assertEquals('DELETE', $r->getVerb());

    }
}