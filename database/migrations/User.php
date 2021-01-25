<?php
    
class UserMigration extends MY_Model {
    
    public function migration()
    {
        migration('users', [
            'id' => 'bigInt|unsigned|auto_increment|primary key',
            'name' => 'varchar(225)|not null',
            'username' => 'varchar(100)|not null',
            'password' => 'varchar(100)|not null'
        ]);
    }

}