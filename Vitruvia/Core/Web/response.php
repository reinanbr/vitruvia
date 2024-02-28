<?php


namespace Vitruvia\Core\Web;

class response{
    
    public function setStatusCode(int $code){
        http_response_code($code);
    }
}