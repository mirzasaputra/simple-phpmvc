<?php

//configurasi database
$db = [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'dbname'   => 'myframework',
    'options'  => [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
];


//configurasi controller
$config['default_controller'] = 'Auth';
