<?php

class SQL_true
{
    public $basename;
    public $table;
    public $link;
    public $id = 0;

    function __construct($basename, $table, $link)
    {
        $this->basename = $basename;
        $this->table = $table;
        $this->link = $link;

    }

    public function delete($id)
    {
        $query = "DELETE FROM $this->table WHERE id=$id;";
        mysqli_query($this->link, $query) or die('Something went bad');
    }

    public function insert($jsonData)
    {
        $whereInsert = "(";
        $values = "(";
        foreach($jsonData as $value=>$key){
            if($value != null){
                $whereInsert .= '"'.$key.'"'.",";
                $values .= $value.",";
            }
        }
        echo $values;
        echo $whereInsert;
        if($values[-1] == ","){
            $values[-1] = ")";
        }
        else{
            $values .= ")";
        }
        if($whereInsert[-1] == ","){
            $whereInsert[-1] = ")";
        }
        else{
            $whereInsert .= ")";
        }
        echo $values;
        echo $whereInsert;
        $mainQuery = "INSERT INTO $this->table$values VALUES$whereInsert;";
	    var_dump($mainQuery);
        mysqli_query($this->link, $mainQuery);

    }

    public function read()
    {
        $query = "SELECT * FROM $this->table;";
        $result = mysqli_query($this->link, $query);
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }

    public function update($id, $name = null, $type = null, $age = null)
    {
        if (isset($name)) {
            $query = "UPDATE $this->table SET name=$name WHERE id=$id;";
            mysqli_query($this->link, $query) or die('Something went bad');
        }
        if (isset($type)) {
            $query = "UPDATE $this->table SET type=$type WHERE id=$id;";
            mysqli_query($this->link, $query) or die('Something went bad');
        }
        if (isset($age)) {
            $query = "UPDATE $this->table SET age=$age WHERE id=$id;";
            mysqli_query($this->link, $query);
        }
    }

    public function fromSqlToJson()
    {
        $json = json_encode($this->read());
        return $json;
    }
    public function getMaxId(){
        $query = "SELECT MAX(id) FROM animals";
        $result = mysqli_query($this->link, $query) or die('Something went bad');
        return intval(mysqli_fetch_array($result)[0]);
    }
}
