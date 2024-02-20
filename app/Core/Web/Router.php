<?php

namespace app\Core\Web;


class Router{
    
    public Request $request;
    protected array $routes = [];

    public function __construct(\app\Core\Web\Request $request){
        $this->request = $request;
    }

    /**
     * The function "get" adds a new route to the "routes" array for the HTTP GET method.
     * 
     * @param $path The path parameter is a string that represents the URL path for which the callback
     * function should be executed.
     * @param $call The "call" parameter is a callback function or method that will be executed when the
     * specified path is accessed using the HTTP GET method.
     */
    public function get($path,$call){
        $this->routes['get'][$path] = $call;
    }

    /**
     * The function `post` adds a new route for handling POST requests in a PHP application.
     * 
     * @param $path The `path` parameter in the `post` function represents the URL path for which the
     * specified callback function will be executed when an HTTP POST request is made to that path.
     * @param $call The `call` parameter in the `post` function is typically a callback function or a
     * reference to a method that should be executed when a POST request is made to the specified
     * ``. This function or method will handle the logic for processing the POST request and
     * generating the appropriate response.
     */
    public function post($path,$call){
        $this->routes['post'][$path] = $call;
    }

    /**
     * The function resolves the requested path and method to call the corresponding route handler or
     * display a 404 error message.
     */
    public function resolve(){
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $call = $this->routes[$method][$path] ?? false;
        if ($call == false){
            echo 'error 404';
            exit;
        }
        echo call_user_func($call);
    }
}