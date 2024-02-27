<?php

namespace Vitruvia\Utils\Json;

class Jsonify
{
    protected array $listHeaders = ['Content-Type: application/json'];
 
    /**
     * The function `headers` in PHP adds a header to a list and returns null.
     * 
     * @param string $header The `headers` function takes a string parameter named ``. This
     * parameter represents a header value that will be added to the `listHeaders` array within the
     * function.
     * 
     * @return null The function `headers` is returning `null`.
     */
    public function headers(string $header):null
    {
        $this->listHeaders[] = $header;
        return null;
    }


    /**
     * The `runHeader` function iterates through a list of headers and sets them using the `header`
     * function in PHP.
     */
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