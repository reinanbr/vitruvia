<div align='center'>
<h2>Vitruvia</h2>
<i>A lightweight PHP micro-framework with an Express.js-style API</i>
<hr>
</div>

Vitruvia is a small, dependency-free PHP framework for building simple web
apps and JSON APIs. If you know Express.js, you already know Vitruvia:
`app.get/post/put/patch/delete`, chainable `res.status().json()/send()`,
`req.params/query/body`, and middleware via `app.use((req, res, next) => ...)`.

## Installation

```bash
composer require reinanbr/vitruvia
```

Requires PHP 8.0 or later.

## Getting started

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Vitruvia\Core\Web\Application;

$app = new Application(__DIR__);

$app->get("/", function ($req, $res) {
    $res->send("Hello, world!");
});

$app->run();
```

> Unlike Node, PHP handles one request per process — there's no persistent
> socket to bind. `run()` (aliased as `listen()` for familiarity) resolves
> the current request and returns; a web server (or `php -S`) is what
> invokes your entry script per request.

## Routing

`$app` exposes `get()`, `post()`, `put()`, `patch()` and `delete()`, each
taking a path and one or more handlers `function ($req, $res, $next)`:

```php
$app->get("/hello/:name", function ($req, $res) {
    $res->send("Hello, {$req->params['name']}!");
});
```

Handlers can also be `[ControllerClass::class, "method"]` callables:

```php
$app->post("/api/getInfoLibs", [GetInfoLibsApiController::class, "getInfoLibs"]);
```

Unmatched routes get a 404 response rendering `views/_404.php`.

## Middleware

`app->use()` registers global middleware that runs before every route, in
registration order. Call `$next()` to continue the chain:

```php
$app->use(function ($req, $res, $next) {
    error_log("{$req->method} {$req->path}");
    $next(); // omit this to short-circuit the request
});
```

A route can also take multiple handlers — each one after the first acts as
route-specific middleware:

```php
$app->get("/admin", $requireAuth, function ($req, $res) {
    $res->send("welcome");
});
```

If a handler throws, Vitruvia catches it and responds with a JSON 500 (as
long as nothing was sent yet) instead of a raw PHP error.

## The request object

- `$req->method` — HTTP method (`GET`, `POST`, ...)
- `$req->path` — request path, without the query string
- `$req->params` — route params captured from `:name`-style segments
- `$req->query` — parsed `$_GET`
- `$req->body` — JSON body when present, otherwise `$_POST`
- `$req->headers` — request headers

## The response object

- `$res->status($code)` — set the status code, chainable
- `$res->set($header, $value)` — set a header, chainable
- `$res->send($body = "")` — write a raw body and end the response
- `$res->json($data)` — write JSON and end the response
- `$res->render($view, $locals = [], $layoutParams = [])` — render a view
  inside `views/layouts/base.php` and end the response
- `$res->redirect($url, $status = 302)` — send a redirect
- `$res->end()` — end the response with whatever was set, no body

```php
$res->status(201)->set("X-Powered-By", "Vitruvia")->json(["created" => true]);
```

## Views and layouts

`$res->render($view, $locals, $layoutParams)` renders `views/{$view}.php`
wrapped in `views/layouts/base.php`:

- `$locals` are extracted as local PHP variables available inside the
  **view** file (e.g. `$name` becomes `<?php echo $name; ?>`).
- `$layoutParams` values replace `{key}` placeholders inside the
  **layout** (e.g. `{title}`, `{navbar}`).
- The layout must contain a `{{content}}` placeholder marking where the
  view is injected.

## Models

Extend `Vitruvia\Core\Models\Model` and declare typed properties plus a
`rules()` method describing validation constraints:

```php
<?php

use Vitruvia\Core\Models\Model;

class LibsModel extends Model
{
    public string $name;
    public string $keyLib;

    public function rules(): array
    {
        return [
            "name" => [self::RULE_REQUIRED],
            "keyLib" => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 20]],
        ];
    }
}
```

```php
$model = new LibsModel();
$model->loadData($req->body);

if (!$model->validate()) {
    $res->status(422)->json(["errors" => $model->errors]);
}
```

Supported rules: `RULE_REQUIRED`, `RULE_MIN`, `RULE_MAX`, `RULE_MATCH`, `RULE_BIT`.

## Example app

A runnable example lives in [`examples/`](examples/). Serve it with PHP's
built-in server:

```bash
php -S localhost:8000 -t examples
```

Then visit `http://localhost:8000/`, `http://localhost:8000/hello/Ada`,
`http://localhost:8000/api/contact?name=Ada`, or POST to
`http://localhost:8000/api/getInfoLibs`.

## License

Released under the [MIT License](LICENSE).
