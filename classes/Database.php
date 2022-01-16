<?php

class Database
{
    public static function getConnection()
    {
        $db_host = "localhost";
        $db_name = "blog_platform";
        $db_user = "joffre";
        $db_pass = "joffre$$";
        $dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8';

        try {
            $db = new PDO($dsn, $db_user, $db_pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}