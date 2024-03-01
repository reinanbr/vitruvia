<?php

use Vitruvia\Core\Web\Application;
use Vitruvia\Utils\Json\Jsonify;

class GetInfoLibsApiController{

    public static function getInfoLibs($request){
        $jsonify = new Jsonify();
        $jsonify->headers('Access-Control-Allow-Origin: *');
    
        return $jsonify->run([
            "status"=>200,
            "message"=>"ok",
            "data"=>$request["input"]
        ]);
    }

    public static function contact(){
        $params = ["name"=>"test"];
        return Application::$app->router->renderView("contact",$params);
    }
}