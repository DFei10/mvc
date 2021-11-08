<?php

namespace Tests\Unit;

use App\Exceptions\ControllerNotFoundException;
use App\Exceptions\RouteNotFoundException;
use App\Router;
use ArgumentCountError;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    protected $router;

    protected function setUp(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';
        $this->router = new Router();
    }
    /** @test */
    public function it_registers_a_route()
    {
        $cb = function () {
            return 'foo';
        };

        $this->router->register('get', '/foo', $cb);

        $this->assertEquals(
            [
                'get' => ['/foo' => $cb]
            ],
            $this->router->routes()
        );
    }

    /** @test */
    public function it_registers_a_get_route()
    {
        $cb = function () {
            return 'foo';
        };

        $this->router->get('/foo', $cb);

        $this->assertEquals(
            [
                'get' => ['/foo' => $cb]
            ],
            $this->router->routes()
        );
    }

    /** @test */
    public function it_registers_a_post_route()
    {
        $cb = function () {
            return 'foo';
        };

        $this->router->post('/foo', $cb);

        $this->assertEquals(
            [
                'post' => ['/foo' => $cb]
            ],
            $this->router->routes()
        );
    }

    /** @test */
    public function it_has_no_routes_when_it_is_created()
    {
        $this->assertEmpty(
            (new Router())->routes()
        );
    }

    /** @test */
    public function it_throws_route_not_found_exception()
    {
        $this->expectException(RouteNotFoundException::class);
        $this->router->resolve();
    }

    /** @test */
    public function it_throws_controller_not_found_exception()
    {
        $controller = new class {};
        $this->router->get('/', ['foo', 'bar']);

        $this->expectException(ControllerNotFoundException::class);
        $this->router->resolve();
    }
}
