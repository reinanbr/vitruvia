<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__."/Controllers/HomeController.php";
require_once __DIR__."/Controllers/GetInfoLibsApiController.php";



use Vitruvia\Core\Web\Application;


$app = new Application(__DIR__);

$app->router->get("/",'home');

$app->router->post('/api/getInfoLibs',[GetInfoLibsApiController::class, "getInfoLibs"]);

$app->router->get("/api/contact",[GetInfoLibsApiController::class, "contact"]);

$app->run();
?>
