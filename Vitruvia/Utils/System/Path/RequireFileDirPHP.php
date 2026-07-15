<?php

namespace Vitruvia\Utils\System\Path;

class RequireFileDirPHP
{
    public static function requireFileDirPHP(string $dir): void
    {
        $fileListDir = GlobFile::globFile("php", $dir);
        foreach ($fileListDir as $phpFile) {
            require_once $phpFile;
        }
    }
}
