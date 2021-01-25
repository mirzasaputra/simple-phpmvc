<?php

class MY_Controller {

    public function __construct()
    {
        $this->db = new Database;
    }

    public function view($view, $data = [])
    {
        //check file view
        if(file_exists('../application/views/' . $view . '.php')){
            extract($data);
            require('../application/views/' . $view . '.php');
        } else {
            die("Sorry, file " . $view . ".php on views doesn't exists.");
        }
    }

    public function model($model)
    {
        //check file model
        if(file_exists('../application/models/' . $model . '.php')){
            require('../application/models/' . $model . '.php');

            //check class
            if(class_exists($model)){
                $this->$model = new $model;
            } else {
                die("Sorry, class <b>" . $model . "</b> doesn't exists.");
            }
        }
    }

}

class MY_Model {

    public function __construct()
    {
        $this->db = new Database();
    }

    public function model($model)
    {
        //check file model
        if(file_exists('../application/models/' . $model . '.php')){
            require('../application/models/' . $model . '.php');

            //check class
            if(class_exists($model)){
                $this->$model = new $model;
            } else {
                die("Sorry, class <b>" . $model . "</b> doesn't exists.");
            }
        }
    }

}