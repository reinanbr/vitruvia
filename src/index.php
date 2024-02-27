<?php

require_once __DIR__.'/../vendor/autoload.php';

use Vitruvia\Core\Web\Application;
use Vitruvia\Utils\Json\Jsonify;

$app = new Application();


$app->router->post('/api',function($request){
    $jsonify = new Jsonify();
    $jsonify->headers('Access-Control-Allow-Origin: *');


    return $jsonify->run([
        "status"=>200,
        "message"=>"ok",
        "data"=>$request["input"]
    ]);
});

$app->run();
?>
