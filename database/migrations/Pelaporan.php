<?php

class PelaporanMigration {

    public function migration()
    {
        migration('pelaporans', [
            'id' => 'bigInt|unsigned|auto_increment|primary key',
            'full_name' => 'varchar(225)|not null',
            'alamat' => 'varchar(225)|not null',
            'koordinate' => 'varchar(255)|not null'
        ]);
    }

}