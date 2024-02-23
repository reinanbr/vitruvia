<?php

namespace Vitruvia\Utils\Json;

class Jsonify
{
    protected array $listHeaders = ['Content-Type: application/json'];
    /**
     * The function sets the headers for an application/json response with CORS support.
     */
    public function headers(string $header):null
    {
        $this->listHeaders[] = $header;
        return null;
    }


    protected function runHeader(){
        foreach($this->listHeaders as $header){
    /*         header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type"); */
            header($header);
        }
    }



    /**
     * The function `compileStr` compiles a JSON string into a formatted JSON array.
     * 
     * @param string $textJson The `compileStr` function takes a JSON string as input in the ``
     * parameter. This JSON string is then decoded into an associative array using `json_decode`. The
     * array is then encoded back into a JSON string with pretty printing using `json_encode` and
     * returned.
     * 
     * @return string The function `compileStr` takes a JSON string as input, decodes it into an
     * associative array, then encodes it back into a JSON string with pretty printing enabled using
     * the `JSON_PRETTY_PRINT` option. Finally, it returns the prettified JSON string.
     */
    public function compileStr(string $textJson): string
    {
        $this->runHeader();
        $jsonCompileArray = json_decode($textJson,true);
        $jsonCompileApp = json_encode($jsonCompileArray,JSON_PRETTY_PRINT);
        return $jsonCompileApp;

    }

    public function run(array $json):string
    {
        $this->runHeader();
        return json_encode($json,JSON_PRETTY_PRINT);
    }
}