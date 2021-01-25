<?php

class Terminal extends MY_Controller {

    public function index()
    {
        $this->data = [
            'title' => 'Terminal'
        ];

        $this->view('terminal', $this->data);
    }

    public function execute()
    {
        $code = explode(' ', $_POST['code']);

        if(isset($code[0])){
            if($code[0] == 'create'){
                if(isset($code[1]) && isset($code[2])){
                    switch($code[1]){
                        case 'controller' : $this->createController($code);break;
                        case 'model' : $this->createModel($code);break;
                        case 'migration' : $this->createMigrations($code);break;
                        case 'seeder' : $this->createSeeder($code);break;
                        default : echo json_encode(['message' => 'Code invalid, please check your code']);
                    }
                } else {
                    echo json_encode(['message' => 'Code invalid, please check your code']);
                }
            } elseif($code[0] == 'migrate'){
                if(isset($code[1])){
                    require('../database/migrations/'. ucwords($code[1]) .'.php');
                    $class = ucwords($code[1]) .'Migration';
                    $migrate = new $class;
                    $migrate->migration();
                    echo json_encode(['message' => 'Migrrations successfully']);
                } else {
                    require('../database/migrations/Init.php');
                    foreach($migrate as $i){
                        require('../database/migrations/'. $i .'.php');
                        $class = ucwords($i .'Migration');
                        $migrate = new $class;
                        $migrate->migration();
                    }
                    echo json_encode(['message' => 'Migrrations successfully']);
                }
            } elseif($code[0] == 'seed'){
                if(isset($code[1])){
                    require('../database/seeds/'. ucwords($code[1]) .'.php');
                    $class = ucwords($code[1]) .'Seed';
                    $seed = new $class;
                    $seed->seeder();
                    echo json_encode(['message' => 'Seeder successfully']);
                } else {
                    require('../database/seeds/Init.php');
                    foreach($seed as $i){
                        require('../database/seeds/'. $i .'.php');
                        $class = ucwords($i .'Seed');
                        $seed = new $class;
                        $seed->seeder();
                    }
                    echo json_encode(['message' => 'Seeder successfully']);
                }
            } else {
                echo json_encode(['message' => 'Code invalid, please check your code']);
            }
        } else {
            echo json_encode(['message' => 'Please input your code']);
        }
    }

    public function createController($name)
    {
        if(file_exists('../application/controllers/'. ucwords($name[2]) .'.php')){
            echo json_encode(['message' => 'Controller has been already exists']);
        } else {
            if(isset($name[3]) && $name[3] == '-r'){
                $content = generateController(ucwords($name[2]));
                $file = fopen('../application/controllers/'. ucwords($name[2]) .'.php', 'w');
                fclose($file);
                fwrite($file, $content);
            } else {
                $content = generateControllerBasic(ucwords($name[2]));
                $file = fopen('../application/controllers/'. ucwords($name[2]) .'.php', 'w');
                fwrite($file, $content);
                fclose($file);
            }
    
            echo json_encode(['message' => 'Controller success added']);
        }
    }

    public function createModel($name)
    {
        if(file_exists('../application/models/'. ucwords($name[2]) .'.php')){
            echo json_encode(['message' => 'Model has been already exists']);
        } else {
            $content = generateModel(ucwords($name[2]));
            $file = fopen('../application/models/'. ucwords($name[2]) .'.php', 'w');
            fwrite($file, $content);
            fclose($file);
    
            echo json_encode(['message' => 'Model success added']);
        }
    }

    public function createMigrations($name)
    {
        if(file_exists('../database/migrations/'. ucwords($name[2]) .'.php')){
            echo json_encode(['message' => 'Migrations has been already exists']);
        } else {
            $content = generateMigrations(ucwords($name[2]));
            $file = fopen('../database/migrations/'. ucwords($name[2]) .'.php', 'w');
            fwrite($file, $content);
            fclose($file);

            $migrate = '
$migrate[] = "'. ucwords($name[2]) .'";';
            $file = fopen('../database/migrations/Init.php', 'a+');
            fwrite($file, $migrate);
            fclose($file);
    
            echo json_encode(['message' => 'Migrations success added']);
        }
    }

    public function createSeeder($name)
    {
        if(file_exists('../database/seeds/'. ucwords($name[2]) .'.php')){
            echo json_encode(['message' => 'Seeder has been already exists']);
        } else {
            $content = generateSeeder(ucwords($name[2]));
            $file = fopen('../database/seeds/'. ucwords($name[2]) .'.php', 'w');
            fwrite($file, $content);
            fclose($file);

            $seed = '
$seed[] = "'. ucwords($name[2]) .'";';
            $file = fopen('../database/seeds/Init.php', 'a+');
            fwrite($file, $seed);
            fclose($file);
    
            echo json_encode(['message' => 'Seeder success added']);
        }
    }

}