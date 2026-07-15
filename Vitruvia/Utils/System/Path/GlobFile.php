<?php

namespace Vitruvia\Utils\System\Path;

class GlobFile
{
    public static function globFile(string $typeFile, string $dir = ""): array
    {
        return glob($dir . "*." . $typeFile) ?: [];
    }
}
