<?php

class App {

    protected $controller;
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        require('../application/config/config.php');

        $this->controller = $config['default_controller'];
        
        $url = $this->parseUrl();

        if(isset($url[0])){
            //set controllerName
            $this->controller = $url[0];
            unset($url[0]);

            if(isset($url[1])){
                //set methodName
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        if(isset($url)){
            //if url exists move to params
            $this->params = array_values($url);
        }

        //check file controller
        if(file_exists('../application/controllers/' . ucwords($this->controller) . '.php')){
            require('../application/controllers/' . ucwords($this->controller) . '.php');

            //check class controller
            if(class_exists($this->controller)){
                $this->controller = new $this->controller;

                //check method from controller
                if(method_exists($this->controller, $this->method)){
                    call_user_func_array([$this->controller, $this->method], $this->params);
                } else {
                    die("Sorry, Method <b>" . $this->method . "</b> doesn't exists.");
                }
            } else {
                die("Sorry, Controller <b>" . ucwords($this->controller) . "</b> doesn't exists.");
            }
        } else {
            die("Sorry, File <b>" . ucwords($this->controller) . ".php</b> doesn't exists.");
        }
    }

    public function parseUrl()
    {
        if(isset($_GET['url'])){
            $url = $_GET['url'];
            $url = trim($url);
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }

}