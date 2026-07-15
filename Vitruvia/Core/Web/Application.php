<?php

namespace Vitruvia\Core\Web;

/**
 * Application mirrors Express's `app`: construct it, register middleware
 * and routes with use()/get()/post()/..., then dispatch the current
 * request with run(). Unlike Node, PHP handles one request per process —
 * there is no persistent socket to listen() on, so run() (and its
 * listen() alias) simply resolves the current request and exits.
 */
class Application
{
    public Router $router;
    public static string $ROOT_DIR;
    public Request $request;
    public Response $response;
    public static Application $app;

    public function __construct(string $rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function use(callable $middleware): void
    {
        $this->router->use($middleware);
    }

    public function get(string $path, callable ...$handlers): void
    {
        $this->router->get($path, ...$handlers);
    }

    public function post(string $path, callable ...$handlers): void
    {
        $this->router->post($path, ...$handlers);
    }

    public function put(string $path, callable ...$handlers): void
    {
        $this->router->put($path, ...$handlers);
    }

    public function patch(string $path, callable ...$handlers): void
    {
        $this->router->patch($path, ...$handlers);
    }

    public function delete(string $path, callable ...$handlers): void
    {
        $this->router->delete($path, ...$handlers);
    }

    public function run(): void
    {
        $this->router->resolve();
    }

    /** Alias for run(), for developers coming from Express. */
    public function listen(): void
    {
        $this->run();
    }
}
