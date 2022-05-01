<?php

require_once(__DIR__ . "/EnvParser.php");

class Database
{

    public static function getConnection()
    {

        $hostname = EnvParser::env("HOSTNAME");
        $username = EnvParser::env("USERNAME");
        $password = EnvParser::env("PASSWORD");
        $database = EnvParser::env("DATABASE");

        return mysqli_connect($hostname, $username, $password, $database);
    }

}
