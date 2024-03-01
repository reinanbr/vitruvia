<?php

namespace Vitruvia\Utils\System\Path;

class GetTypeFile{
    public static function getTypeFile(String $filename):String{
        if($filename==""){
            return 0;
        }else{
            $typeFile = explode(".",$filename)[1];
            return $typeFile;
        }
    }
}