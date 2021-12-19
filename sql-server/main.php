<?php
//require_once "true-sql.php";
require_once "animal.php";
require_once "actions.php";

function main()
{
    $method = $_SERVER['REQUEST_METHOD'];
    $url = $_SERVER['REQUEST_URI'];
    $sql = mysqli_connect('127.0.0.1', 'root', 'Cra5hLoy@ale', 'creatures');
    $path = parse_url($url, PHP_URL_PATH);
    $data = file_get_contents('php://input');
    switch ($method) {
        case "GET":
            $animal = new Animal;
            getAnimal($url, $path, $animal, $sql);
            break;
        case  "DELETE":
            $animal = new Animal;
            $animal = $animal->find(intval($url[-1]), $sql);
            deleteId($sql, $animal);
            break;
        case "POST":
            $animal = new Animal;
            addAnimal($sql, $data, $animal);
            break;
        case "PUT":
            echo intval($url[-1]);
            $animal = new Animal;
            $animal = $animal->find(intval($url[-1]), $sql);
            var_dump($animal);
            updateId($sql, $data, $animal);
            break;
    }
}

main();