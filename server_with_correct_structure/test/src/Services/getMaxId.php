<?php
require_once (__DIR__."/../Services/Database.php");
class RequestMaxId

{
    public static function getMaxId()
    {
        $database = new Database();
        $connection = $database->getConnection();
        $query = "SELECT MAX(id) FROM animals;";
        $result = $connection->query($query);
        return intval(mysqli_fetch_array($result)[0]);
    }

}