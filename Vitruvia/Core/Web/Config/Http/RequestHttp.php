<?php

namespace Vitruvia\Core\Web\Config\Http;

class RequestHttp
{
    public static function getPath(): string
    {
        $uri = $_SERVER["REQUEST_URI"] ?? "/";
        $position = strpos($uri, '?');
        if ($position === false) {
            return $uri;
        }
        return substr($uri, 0, $position);
    }

    public static function getMethod(): string
    {
        return $_SERVER["REQUEST_METHOD"] ?? "GET";
    }
}
