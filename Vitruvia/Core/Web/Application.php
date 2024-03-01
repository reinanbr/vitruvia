<?php

namespace Vitruvia\Core\Web;
use Vitruvia\Utils\System\Path;

/* The `class Application` is defining a class called `Application` within the `config\core` namespace.
This class has a property called `` of type `Router`. It also has a constructor method that
initializes the `` property by creating a new instance of the `Router` class. */
class Application
{
    public Router $router;
    public static String $ROOT_DIR;
    public Request $request;
    public Response $response;
    public static Application $app;

    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new response();
        $this->router = new Router($this->request,$this->response);
        
    }

    public function run(){
        echo $this->router->resolve();
    }
}

