<?php

use Vitruvia\Core\Web\Application;
use Vitruvia\Core\Web\Request;
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

    public static function contact($request){


        $name = $request["name"];

        $paramsContent = ["name"=>"$name"];

        $paramsLayout = ["title"=>"ReySofts - Api de Consumo",
                        "navbar"=>"Api de Consumos"];

        return Application::$app->router->renderView("contact",$paramsContent,$paramsLayout);
    }
}