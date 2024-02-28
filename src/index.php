<?php

require_once __DIR__.'/../vendor/autoload.php';

use Vitruvia\Core\Web\Application;
use Vitruvia\Utils\Json\Jsonify;
use Vitruvia\Core\Controllers\SiteController;


$app = new Application(__DIR__);


$app->router->post('/api',function($request){
    $jsonify = new Jsonify();
    $jsonify->headers('Access-Control-Allow-Origin: *');


    return $jsonify->run([
        "status"=>200,
        "message"=>"ok",
        "data"=>$request["input"]
    ]);
});

$app->router->get("/",'home');

$app->router->post("/conc",[SiteController::class, "contact"]);

$app->run();
?>
