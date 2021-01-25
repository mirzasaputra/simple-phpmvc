<?php

if(!function_exists('base_url')){
    function base_url($baseurl = null)
    {
        $url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http');
        $url .= '://'. $_SERVER['HTTP_HOST'];
        $url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        $url = rtrim($url, '/public');

        return $url .'/'. $baseurl;
    }
}

if(!function_exists('generateController')){
    function generateController($name)
    {
        $data = '<?php

class '. $name .' extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        //write your code..
    }
    
    public function index()
    {
        //write your code
    }
    
    public function detail($id)
    {
        //write your code
    }
    
    public function insert()
    {
        //write your code
    }
    
    public function edit($id)
    {
        //write your code
    }
    
    public function update($id)
    {
        //write your code
    }
    
    public function destroy($id)
    {
        //write your code
    }

}';
        return $data;
    }
}

if(!function_exists('generateControllerBasic')){
    function generateControllerBasic($name)
    {
        $data = '<?php

class '. $name .' extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        //write your code..
    }
    
    public function index()
    {
        //write your code
    }

}';
        return $data;
    }
}

if(!function_exists('generateModel')){
    function generateModel($name)
    {
        $data = '<?php

class '. $name .' extends MY_Model {

    private $table = "'. strtolower($name) .'s";
    private $primary_key = "id";
    
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }
    
    public function update($data, $where)
    {
        $this->db->where($this->primary_key, $where);
        return $this->db->update($this->table, $data);
    }
    
    public function destroy($data)
    {
        return $this->db->destroy($this->table, $data);
    }
    
}';

        return $data;
    }

}

if(!function_exists('generateMigrations')){
    function generateMigrations($name)
    {
        $data = "<?php

class ". $name ."Migration {

    public function migration()
    {
        migration('". strtolower($name) ."s', [
            'id' => 'bigInt|unsigned|auto_increment|primary key',
        ]);
    }

}";
        return $data;
    }
}

if(!function_exists('migration')){
    function migration($table, $data)
    {
        $fields = '';
        foreach($data as $field=>$value){
            $value = explode('|', $value);
            $values = '';
            foreach($value as $f=>$v){
                $values .= $v .' ';
            }
            $values = trim($values);
            $values = rtrim($values, ' ');

            $fields .= $field .' '. $values .', ';
        }
        $fields = trim($fields);
        $fields = rtrim($fields, ', ');

        $db = new Database();

        if($db->checkTable($table) <= 0){
            $query = "CREATE TABLE ". $table ." (". $fields .", created_at timestamp default current_timestamp)";
    
            $db->query($query);
            $db->execute();
        }
    }
}

if(!function_exists('generateSeeder')){
    function generateSeeder($name)
    {
        $data = "<?php

class ". $name ."Seed extends MY_Model {

    public function seeder()
    {
        //write your code
    }

}";
        return $data;
    }
}