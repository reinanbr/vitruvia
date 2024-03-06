<?php

namespace Vitruvia\Core\Web;
use Vitruvia\Core\Controllers\SiteController;


class Router{
    
    public Request $request;
    public Response $response;
    protected array $routes = [];
    protected string $dirViews = "/";

    public function __construct(Request $request, Response $response){
        $this->request = $request;
        $this->response = $response;
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
        $this->routes['GET'][$path] = $call;
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
        $this->routes['POST'][$path] = $call;
    }


    public function resolve(){
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $call = $this->routes[$method][$path] ?? false;

        if ($call == false){
            $this->response->setStatusCode(404);
            return $this->renderView("_404");
        }
  /*       if (is_array($call)){
            return call_user_func($call);///
        } */
        if (is_string($call)){
            return $this->renderView($call);
        }
        $requestMethod = $this->request->getBody();
        return call_user_func($call,$requestMethod);
    }

    

    public function renderView($view,$paramsContent=[],$paramsLayout=[]){

        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyViewValues($view,$paramsContent);
        $keysParamsLayout = array_keys($paramsLayout);
        $keysParamsLayoutContent = array_map(function($item){
            return "{".$item."}";
        },$keysParamsLayout);
        $layoutContent = str_replace($keysParamsLayoutContent,array_values($paramsLayout),$layoutContent);
        return str_replace("{{content}}",$viewContent,$layoutContent);
    }

    public function renderContent($viewContent){

        $layoutContent = $this->layoutContent();
        return str_replace("{{content}}",$viewContent,$layoutContent);
    }

    protected function layoutContent(){ 
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/base.php";
        return ob_get_clean();
    }

    protected function renderOnlyViewValues($view,$params){
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        $viewContent = ob_get_clean();
        $keys = array_keys($params);
        $keysContent = array_map(function($item){
           return "{".$item."}";
        },$keys);

        return str_replace($keysContent,array_values($params),$viewContent);

    }
}