<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . "/Controllers/GetInfoLibsApiController.php";

use Vitruvia\Core\Web\Application;

$app = new Application(__DIR__);

// Global middleware, like Express's app.use() — runs before every route.
$app->use(function ($req, $res, $next) {
    error_log("{$req->method} {$req->path}");
    $next();
});

$app->get("/", function ($req, $res) {
    $res->render("home");
});

// Route params, like Express's "/hello/:name".
$app->get("/hello/:name", function ($req, $res) {
    $res->send("Hello, {$req->params['name']}!");
});

$app->get("/api/contact", [GetInfoLibsApiController::class, "contact"]);
$app->post("/api/getInfoLibs", [GetInfoLibsApiController::class, "getInfoLibs"]);

$app->run();
