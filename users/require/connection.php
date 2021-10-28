<?php
    function connection(){
        $db['db_host'] = "127.0.0.1";
        $db['db_user'] = "root";
        $db['db_pass'] = "";
        $db['db_name'] = "m_fashion_shop";
        foreach($db as $key => $value){
            define(strtoupper($key), $value);
        }
        try{
            $connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASS);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection; 
        }catch(PDOException $error){
           echo "ERROR DO CONNECT DB {$error->getMessage()} VERIFY YOUR CONNECTION FILE";
            return null;
        }
    }
    $conn = connection();
?>