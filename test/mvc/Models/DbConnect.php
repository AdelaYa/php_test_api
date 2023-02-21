<?php

namespace Models;

use PDO;

class DbConnect
{
    private static ?PDO $dbConn = null;

    public static function getConnect(): PDO
    {
        if (!self::$dbConn) {
            try {
                $db_host = "localhost";
                $db_user = "db_user";
                $db_password = "pass";
                $db_base = "users";

                $dsn = "mysql:host=$db_host;dbname=$db_base;";
                self::$dbConn = new PDO($dsn, $db_user, $db_password);
            } catch (Exception $ex) {
                echo "Не удалось соединиться с базой: " . $ex->getMessage();
                die;
            }
        }
        return self::$dbConn;
    }
}