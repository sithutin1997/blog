<?php

    define('MYSQL_USER','root');
    define('MYSQL_PASSWORD','root');
    define('MYSQL_HOST','localhost');
    define('MYSQL_DATABASE','blog');

    $options = array (PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

    $pdo = new PDO(
        'mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DATABASE,MYSQL_USER,MYSQL_PASSWORD,$options
    );

?>
