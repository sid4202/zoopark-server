<?php

require_once(__DIR__ . "/EnvParser.php");

class Database
{

    public static function getConnection()
    {

        $hostname = env("HOSTNAME");
        $username = env("USERNAME");
        $password = env("PASSWORD");
        $database = env("DATABASE");

        return mysqli_connect($hostname, $username, $password, $database);
    }

}
