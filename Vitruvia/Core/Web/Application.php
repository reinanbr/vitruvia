<?php


namespace Vitruvia\Core\Web;


/* The `class Application` is defining a class called `Application` within the `config\core` namespace.
This class has a property called `` of type `Router`. It also has a constructor method that
initializes the `` property by creating a new instance of the `Router` class. */
class Application
{
    public Router $router;
    public Request $request;
    public function __construct()
    {
        
        $this->request = new Request();
        $this->router = new Router($this->request);
    }

    public function dir_views(string $dirViews){
        $this->router->set_dir_views($dirViews);
    }

    public function run(){
        echo $this->router->resolve();
    }

}

