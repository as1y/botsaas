<?php
return [
    'LAYOUT' => 'MAIN',
    'NAME' => 'SIMPLER',
    'BASETEL' => '+7(111)111-11-11',
    'DOMAIN' => 'test.ru',
    'LOGO' => 'assets/base/logo.png',
    'USERTABLE' => 'users',
    'BASEMAIL' => [
        'name' => 'Simpler',
        'email' => 'info@test.ru'
    ],


    'db' => [
        'dsn' => 'mysql:host=127.0.0.1;dbname=simpler;charset=utf8;port=3306',
        'user' => 'dbuser',
        'pass' => 'rhrhHKLD83746627284772pqweR',
    ],
    'mail' => [
        'API_USER_ID' => 'e3a52b4091b34385f6b5fdaf2a25be3a',
        'API_SECRET' => 'eddcae62eed298eafd63b1ea9b97744e',
        'TOKEN_STORAGE' => 'file',
        'FILE_STORAGE_DIR' => WWW.'/tmp' // Папка в которой создается токен
    ]
];