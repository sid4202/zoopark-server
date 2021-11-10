<?php
function getAnimal($json, $url, $path)
{
    if ($path == "/animals") {
        print_r($json);
    }
    if ($path == "/animal/" . $url[-1]) {
        foreach ($json as $value) {
            if ($value["id"] == $url[-1]) {
                print_r($value);
            }
        }
    }
}

function updateId($json, $url, $path,$data)
{
    $data = '['.$data.']';
    $jsonData = json_decode($data, true);
    if ($path == "/animal/" . $url[-1]) {
        $i = 0;
        foreach ($json as $value){
            $i+=1;
            foreach ($value as $key){
                if(key($key) == key($jsonData[0][$i])){
                    $key = $jsonData[0][$i];
                }
        }
    }
    }

}

function addAnimal($json, $data)
{
    $data = '['.$data.']';
    $jsonData = json_decode($data, true);
    if (!key_exists("name",$jsonData[0])) {
        $jsonData[0]["name"] = null;
    }
    if (!key_exists("id",$jsonData[0])) {
        $jsonData[0]["id"] = $json[sizeof($json) - 1]["id"] + 1;
    }
    if (!key_exists("type",$jsonData[0])) {
        $jsonData[0]["type"] = null;
    }
    if (!key_exists("age",$jsonData[0])) {
        $jsonData[0]["age"] = null;
    }
    $jsonData = $jsonData[0];
    $json[] = $jsonData;
    return $json;
}

$method = $_SERVER['REQUEST_METHOD'];
$filename = 'animals.json';
$file = fopen($filename, 'r+');
$json = fread($file, filesize($filename));
$list = json_decode($json, true);
$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$data = file_get_contents('php://input');
switch ($method) {
    case "GET":
        getAnimal($list, $url, $path);
        break;
    case  "DELETE":
        echo "В ответе должно быть пустое тело запроса и код HTTP-ответа 204. (по умолчанию он 200)";
        break;
    case "POST":
        $list = addAnimal($list, $data);
        fwrite($file, json_encode($json));
        fclose($file);
        break;
    case "PUT":
        updateId($list, $url, $path, $data);
        fwrite($file, json_encode($json));
        fclose($file);
        break;
}
