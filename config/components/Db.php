<?php

class Db
{
    public static function getConnection()
    {
        $params = include(ROOT . '/config/db_params.php');

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);
        $db->exec('SET NAMES utf8mb4');

        return $db;
    }

}
