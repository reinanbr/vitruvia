<?php

namespace Vitruvia\Utils\System\Path;

class GetTypeFile
{
    public static function getTypeFile(string $filename): string
    {
        if ($filename === "") {
            return "";
        }
        return explode(".", $filename)[1] ?? "";
    }
}
