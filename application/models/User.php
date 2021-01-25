<?php

class User extends MY_Model {

    private $table = "users";
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
    
}