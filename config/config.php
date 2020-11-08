<?php

    define('MYSQL_USER','root');
    define('MYSQL_PASSWORD','root');
    define('MYSQL_HOST','localhost');
    define('MYSQL_DATABASE','blog');



    $pdo = new PDO(
        'mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DATABASE,MYSQL_USER,MYSQL_PASSWORD,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

?>
