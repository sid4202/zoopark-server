<?php
require_once "true-sql.php";

class Animal
{
    public $name;
    public $age;
    public $type;
    public $id;

    public function delete($link)
    {
        $query = "DELETE FROM animals WHERE id=$this->id;";
        mysqli_query($link, $query);
    }

    public function create($jsonData, $link)
    {
        $whatInsert = "(";
        $values = "(";
        foreach ($jsonData as $value => $key) {
            if ($value != null) {
                if (is_numeric($key)) {
                    $whatInsert .= $key . ",";
                } else {
                    $whatInsert .= '"' . $key . '"' . ",";
                }
                $values .= $value . ",";
            }
        }
        echo $values;
        echo $whatInsert;
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
        echo $values;
        echo $whatInsert;
        $mainQuery = "INSERT INTO animals$values VALUES$whatInsert;";
        var_dump($mainQuery);
        mysqli_query($link, $mainQuery);

    }

    public function find(int $id, $link)
    {
        $query = "SELECT * FROM animals WHERE id=$id;";
        $result = mysqli_query($link, $query);
        return mysqli_fetch_object($result, "Animal");
    }

    public function all($link)
    {
        $query = "SELECT * FROM animals;";
        $result = mysqli_query($link, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function update($link, string $name = null, string $type = null, int $age = null)
    {
        if (isset($name)) {
            $query = "UPDATE animals SET name=$name WHERE id=$this->id;";
            mysqli_query($link, $query) or die('Something went bad');
        }
        if (isset($type)) {
            $query = "UPDATE animals SET type=$type WHERE id=$this->id;";
            mysqli_query($link, $query) or die('Something went bad');
        }
        if (isset($age)) {
            $query = "UPDATE animals SET age=$age WHERE id=$this->id;";
            mysqli_query($link, $query);
        }
    }

    public function getMaxId($link)
    {
        $query = "SELECT MAX(id) FROM animals;";
        $result = mysqli_query($link, $query) or die('Something went bad');
        return intval(mysqli_fetch_array($result)[0]);
    }
}
