<?php


namespace Vitruvia\Core\Web\Config\Http;

class RequestHttp
{

    public static function getPath()
    {
        $uri = $_SERVER["REQUEST_URI"] ?? "/";
        $path = $uri;
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public static function getMethod()
    {
        $methodHttp = $_SERVER["REQUEST_METHOD"];
        return $methodHttp;
    }

    public function getInputHttp()
    {
        $phpInputJson = json_decode(file_get_contents("php://input"));

        return $phpInputJson;
    }
    public function getDataMethod()
    {
        $methodHttp = self::getMethod();
        if ($methodHttp == "GET") {
            return $_GET;
        } else if ($methodHttp == "POST") {
            return $_POST;
        }
    }

    public function getDataRequest()
    {
        return array(
            "input"=>self::getInputHttp(),
            "dataParams"=>self::getDataMethod()
        );
    }
}