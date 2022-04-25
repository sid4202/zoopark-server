<?php
require_once(__DIR__ . "/../Models/Model.php");
require_once (__DIR__ . "/../Services/Database.php");
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
        if($this->databaseConnection->query($query))
            echo "deleted";
    }
    public function delete_everything()
    {
        $query = "DELETE FROM animals;";
        if($this->databaseConnection->query($query))
            echo "deleted";
    }

    public function create($jsonData)
    {
        $id = $jsonData['id'];
        $whatInsert = "($id,";
        $values = "(id,";
        $inserts = [];
        $paramStr = "";
        foreach ($jsonData as $value => $key) {
            if ($value != null) {
                if (is_numeric($key)){
                continue;
                }
                $whatInsert .= "?" . ",";
                $values .= $value . ",";
                $inserts[] = $key;
                $paramStr .= "s";
            }

        }
        $paramsForCreate = [];

        $paramsForCreate[] = $paramStr;
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

        $mainQuery = "INSERT INTO animals$values VALUES$whatInsert;";
        $this->query($mainQuery, $paramsForCreate);
        echo $this->toJson($this->find(RequestMaxId::getMaxId()));
    }

    public function update(string $name = null, string $type = null, int $age = null)
    {
        if (isset($name)) {
            $query = "UPDATE animals SET name=? WHERE id=$this->id;";
            $params = ["s", [$name]];
            $this->query($query, $params);
            $this->databaseConnection->query($query);
        }

        if (isset($type)) {
            $query = "UPDATE animals SET type=? WHERE id=$this->id;";
            $params = ["s", [$type]];
            $this->query($query, $params);
            $this->databaseConnection->query($query);
        }

        if (isset($age)) {
            $query = "UPDATE animals SET age=? WHERE id=$this->id;";
            $params = ["s", [$age]];
            $this->query($query, $params);
            $this->databaseConnection->query($query);
        }
        echo $this->toJson($this->find($this->id));
    }

    public function find(int $id)
    {
        $query = "SELECT * FROM animals WHERE id=$id;";
        $result = $this->databaseConnection->query($query);

        return mysqli_fetch_object($result, Animal::class);
    }
    public function toJson($object)
    {
        return json_encode($object);
    }
}
