<?php

require_once __DIR__.'/../../vendor/autoload.php';

use app\Core\Web\Application;
use app\Utils\Json\Jsonify;


$app = new Application();

$app->router->get('/',function(){
    $jsonify = new Jsonify();
    $jsonify->headers('Access-Control-Allow-Origin: *');

    return $jsonify->run([
        "status"=>200,
        "message"=>"ok"
    ]);
});

?>