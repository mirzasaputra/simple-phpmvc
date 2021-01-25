<?php

class UserSeed extends MY_Model {

    public function seeder()
    {
        $this->model('User');
        
        $this->User->insert([
            'id' => '',
            'name' => 'Mirza Saputra',
            'username' => 'mirza23',
            'password' => password_hash('12345', PASSWORD_DEFAULT)
        ]);
    }

}