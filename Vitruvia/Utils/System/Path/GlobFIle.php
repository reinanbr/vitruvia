<?php

namespace Vitruvia\Utils\System\Path;
use Vitruvia\Utils\System\Shell;

class GlobFile{
    public static function globFile(String $typeFile, String $dir=""):array{
        $listFile = explode("\n",Shell::runShell("ls $dir*.$typeFile"));
        $resGlob = array();
        foreach($listFile as $file){
            $type = GetTypeFile::getTypeFile($file);
            if($type==$typeFile){
                $resGlob[] = $file;
            }
        }
        return $resGlob;
    }
}
