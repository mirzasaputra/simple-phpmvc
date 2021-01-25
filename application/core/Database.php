<?php

class Database {

    protected $hostname;
    protected $username;
    protected $password;
    protected $db_name;
    protected $conn;
    protected $stmt;

    public function __construct()
    {
        require('../application/config/config.php');

        $this->hostname = $db['hostname'];
        $this->username = $db['username'];
        $this->password = $db['password'];
        $this->db_name  = $db['dbname'];

        $dsn = "mysql:hostname=". $this->hostname .";dbname=". $this->db_name;

        $options = $db['options'];

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public function query($query)
    {
        $this->stmt = $this->conn->prepare($query);
        return $this;
    }

    public function bind($params, $value, $type = null)
    {
        ($value == '') ? $value = null : $value = $value;
        if(is_null($type)){
            switch(true){
                case is_int($value) : $type = PDO::PARAM_INT;break;
                case is_bool($value) : $type = PDO::PARAM_BOOL;break;
                case is_null($value) : $type = PDO::PARAM_NULL;break;
                default : $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($params, $value, $type);
    }

    public function execute()
    {
        $this->stmt->execute();
    }

    public function get($table)
    {
        $query = "SELECT * FROM " . $table;
        $this->query($query);
        return $this;
    }

    public function get_where($table, $fields = [])
    {
        $values = "";
        foreach($fields as $field=>$value){
            $values .= "" . $field . "=:" . $field . " && ";
        }
        $values = trim($values);
        $values = rtrim($values, ' && ');

        $query = "SELECT * FROM ". $table ." WHERE ". $values;
        $this->query($query);

        //bind value
        foreach($fields as $field=>$value){
            $this->bind($field, $value);
        }
    }

    public function insert($table, $fields = [])
    {
        $values = "";
        foreach($fields as $field=>$value){
            $values .= ":". $field .", ";
        }
        $values = trim($values);
        $values = rtrim($values, ', ');

        date_default_timezone_set('asia/jakarta');
        $query = "INSERT INTO ". $table . " VALUES(" . $values . ", '". date('Y-m-d H:i:s') ."')";
        $this->query($query);

        //bind value
        foreach($fields as $field=>$value){
            $this->bind($field, $value);
        }

        $this->execute();
    }

    public function destroy($table, $fields = [])
    {
        $values = "";
        foreach($fields as $field=>$value){
            $values .= "". $field ."=:". $field ." && ";
        }
        $values = trim($values);
        $values = rtrim($values, ' && ');

        $query = "DELETE FROM ". $table ." WHERE ". $values;
        $this->query($query);

        //bind value
        foreach($fields as $field=>$value){
            $this->bind($field, $value);
        }

        $this->execute();
    }

    private $whereValue;

    public function where($field, $value = null)
    {
        if(is_null($value)){
            $this->whereValue = $field;
        } else {
            $this->whereValue = $field. "='". $value ."'";
        }

        return $this;
    }

    public function update($table, $fields = [])
    {
        $values = "";
        foreach($fields as $field=>$value){
            $values .= "". $field ."=:". $field .", ";
        }
        $values = trim($values);
        $values = rtrim($values, ', ');

        $query = "UPDATE ". $table ." SET ". $values ." WHERE ". $this->whereValue;
        $this->query($query);

        //bind value
        foreach($fields as $field=>$value){
            $this->bind($field, $value);
        }

        $this->execute();
    }

    public function result()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function result_array()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function row()
    {
        $this->execute();
        return $this->stmt->fetchObject();
    }

    public function row_array()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function num_rows()
    {
        $this->execute();
        return (int) $this->stmt->fetchColumn();
    }

	public function checkTable($table)
	{
        $result = $this->conn->query("SELECT * FROM information_schema.TABLES WHERE table_schema='". $this->db_name ."' && table_name='". $table ."'");
        return $result->rowCount();
	}

}