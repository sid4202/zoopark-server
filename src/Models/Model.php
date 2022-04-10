<?php

require_once (__DIR__ . "/../Services/Database.php");
class Model
{
    /**
     * @var mysqli
     */
    protected $databaseConnection;

    public function __construct()
    {
        $this->databaseConnection = Database::getConnection();
    }
    public function query(string $query, array $params)
    {
        var_dump($query);
        $exec_query = $this->databaseConnection->stmt_init();
        $exec_query->prepare($query);
        $exec_query->bind_param($params[0], ...$params[1], ...$params[2]);
        $exec_query->execute();
        $query->get_result();
    }
}