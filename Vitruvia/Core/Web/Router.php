<?php

namespace Vitruvia\Core\Web;

/**
 * Express-style router: routes are matched by method + path (":id"-style
 * params supported), and each match runs through a middleware chain —
 * global middleware registered via use(), then the route's own handlers —
 * where every handler receives (Request $req, Response $res, callable $next).
 */
class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];
    protected array $middleware = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function use(callable $middleware): void
    {
        $this->middleware[] = $middleware;
    }

    public function get(string $path, callable ...$handlers): void
    {
        $this->addRoute('GET', $path, $handlers);
    }

    public function post(string $path, callable ...$handlers): void
    {
        $this->addRoute('POST', $path, $handlers);
    }

    public function put(string $path, callable ...$handlers): void
    {
        $this->addRoute('PUT', $path, $handlers);
    }

    public function patch(string $path, callable ...$handlers): void
    {
        $this->addRoute('PATCH', $path, $handlers);
    }

    public function delete(string $path, callable ...$handlers): void
    {
        $this->addRoute('DELETE', $path, $handlers);
    }

    protected function addRoute(string $method, string $path, array $handlers): void
    {
        $keys = [];
        $pattern = preg_replace_callback('#:([a-zA-Z_][a-zA-Z0-9_]*)#', function ($match) use (&$keys) {
            $keys[] = $match[1];
            return '([^/]+)';
        }, $path);

        $this->routes[$method][] = [
            'pattern' => '#^' . $pattern . '$#',
            'keys' => $keys,
            'handlers' => $handlers,
        ];
    }

    public function resolve(): void
    {
        foreach ($this->routes[$this->request->method] ?? [] as $route) {
            if (preg_match($route['pattern'], $this->request->path, $matches)) {
                array_shift($matches);
                $this->request->params = array_combine($route['keys'], $matches);
                $this->dispatch(array_merge($this->middleware, $route['handlers']));
                return;
            }
        }

        $this->response->status(404);
        $this->response->render('_404');
    }

    protected function dispatch(array $stack): void
    {
        $index = 0;
        $next = function () use (&$index, &$next, $stack) {
            if (!isset($stack[$index])) {
                return;
            }
            $handler = $stack[$index++];
            try {
                $handler($this->request, $this->response, $next);
            } catch (\Throwable $e) {
                $this->handleError($e);
            }
        };
        $next();
    }

    protected function handleError(\Throwable $e): void
    {
        if ($this->response->isSent()) {
            return;
        }
        $this->response->status(500);
        $this->response->json([
            'status' => 500,
            'message' => $e->getMessage(),
        ]);
    }

    public function renderView(string $view, array $paramsLayout = [], array $valuesParams = []): string
    {
        $layoutContent = $this->layoutContent();
        $viewContentWithValues = $this->renderOnlyViewValues($view, $valuesParams);

        $placeholders = array_map(fn ($key) => "{" . $key . "}", array_keys($paramsLayout));
        $layoutContent = str_replace($placeholders, array_values($paramsLayout), $layoutContent);

        return str_replace("{{content}}", $viewContentWithValues, $layoutContent);
    }

    protected function layoutContent(): string
    {
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/base.php";
        return ob_get_clean();
    }

    protected function renderOnlyViewValues(string $view, array $values): string
    {
        foreach ($values as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}
