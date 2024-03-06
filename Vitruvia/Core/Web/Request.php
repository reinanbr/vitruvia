<?php

namespace Vitruvia\Core\Web;
use Vitruvia\Core\Web\Config\Http\RequestHttp;


class Request extends RequestHttp{

    public function getBody(){
        $body = [];
        if(self::getMethod()==="GET"){
            foreach($_GET as $key=> $value){
                $body[$key] = filter_input(INPUT_GET,$key,FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if(self::getMethod()==="POST"){
            foreach($_POST as $key=> $value){
                $body[$key] = filter_input(INPUT_POST,$key,FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;

    }
}