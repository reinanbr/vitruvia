<?php

namespace Vitruvia\Utils\System\Path;

class requireFileDirPHP{
    public static function requireFileDirPHP(String $dir){
        $fileListDir = GlobFile::globFile("php",$dir);
        foreach($fileListDir as $phpFile){
            require_once $phpFile;
        }
    }
}