<?php

require_once (__DIR__."/../Services/Database.php");
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
}