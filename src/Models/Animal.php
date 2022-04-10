<?php
require_once(__DIR__ . "/../Models/Model.php");

class Animal extends Model
{
    public $name;
    public $age;
    public $type;
    public $id;

    public function all()
    {
        $result = $this->databaseConnection->query('SELECT * from animals;');

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function delete()
    {
        $query = "DELETE FROM animals WHERE id=$this->id;";
        $this->databaseConnection->query($query);
    }

    public function create($jsonData)
    {
        $whatInsert = "(";
        $values = "(";
        $inserts = [];
        $fields = [];
        $paramStr = "";
        foreach ($jsonData as $value => $key) {
            if ($value != null) {
                    $whatInsert .= "?" . ",";
                $values .= "?" . ",";
                $inserts[] = $key;
                $fields[] = $value;
                $paramStr .= "ss";
            }

        }
        $paramsForCreate = [];

        $paramsForCreate[] = $paramStr;
        $paramsForCreate[] = $fields;
        $paramsForCreate[] = $inserts;

        if ($values[-1] == ",") {
            $values[-1] = ")";
        } else {
            $values .= ")";
        }

        if ($whatInsert[-1] == ",") {
            $whatInsert[-1] = ")";
        } else {
            $whatInsert .= ")";
        }
        var_dump($inserts);
        var_dump($fields);
        var_dump($paramStr);
        $mainQuery = "INSERT INTO animals$values VALUES$whatInsert;";
        $this->query($mainQuery, $paramsForCreate);
        echo $this->toJson($this->find(RequestMaxId::getMaxId()));
    }

    public function update(string $name = null, string $type = null, int $age = null)
    {
        if (isset($name)) {
            $query = "UPDATE animals SET name=$name WHERE id=$this->id;";
            $this->databaseConnection->query($query);
        }

        if (isset($type)) {
            $query = "UPDATE animals SET type=$type WHERE id=$this->id;";
            $this->databaseConnection->query($query);
        }

        if (isset($age)) {
            $query = "UPDATE animals SET age=$age WHERE id=$this->id;";
            $this->databaseConnection->query($query);
        }
        echo $this->toJson($this->find($this->id));
    }

    public function find(int $id)
    {
        $query = "SELECT * FROM animals WHERE id=$id;";
        $result = $this->databaseConnection->query($query);

        return mysqli_fetch_object($result, "Animal");
    }
    public function toJson($object)
    {
        return json_encode($object);
    }
}
