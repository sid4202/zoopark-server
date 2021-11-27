<?php
require_once "sql-class.php";
require_once "fill-data.php";
function getAnimal($url, $path, $sqlTable)
{
    $json = json_decode($sqlTable->fromSqlToJson(),1);
    if ($path == "/animals") {
        echo json_encode($json);
    }
    if ($path == "/animal/" . $url[-1]) {
        foreach ($json as $value) {
            if ($value["id"] == $url[-1]) {
                echo json_encode($value);
            }
        }
    }
}

function deleteId($path,$sqlTable){
    $sqlTable->delete($path[-1]);
}

function addAnimal($data, $sql){
    $jsonData = json_decode($data, true);
    $maxId = $sql->getMaxId();
    $jsonData['id'] = $maxId+1;
    echo $maxId;
    $sql->insert($jsonData);
    var_dump($sql->fromSqlToJson());
}
function updateId($path, $data,$sql){
    $jsonData = json_decode($data, true);
    fillArray($jsonData);
    $sql->update($path[-1], $jsonData['name'],$jsonData['type'], $jsonData['age']);
}

define('BASENAME', 'creatures');
define('TABLE', 'animals');


function main()
{
    $link = mysqli_connect('localhost', 'root','Cra5hLoy@ale', 'creatures');
    $method = $_SERVER['REQUEST_METHOD'];
    $sql = new SQL(BASENAME, TABLE, $link);
    $url = $_SERVER['REQUEST_URI'];
    $path = parse_url($url, PHP_URL_PATH);
    $data = file_get_contents('php://input');
    switch ($method) {
        case "GET":
            getAnimal($url, $path,$sql);
            break;
        case  "DELETE":
            deleteId($path, $sql);
            break;
        case "POST":
            addAnimal($data, $sql);
            break;
        case "PUT":
            updateId($path,$data, $sql);
            break;
    }
}
main();