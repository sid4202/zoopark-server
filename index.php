<?php
function getAnimal($json, $url, $path)
{
    if ($path == "/animals") {
        echo file_get_contents('animals.json');
    }
    if ($path == "/animal/" . $url[-1]) {
        foreach ($json as $value) {
            if ($value["id"] == $url[-1]) {
               echo json_encode($value);
            }
        }
    }
}

function updateId(&$json, $url, $path,$data)
{
    $jsonData = json_decode($data, true);
    if ($path == "/animal/" . $url[-1]) {
        foreach($json as $key => $value){
            if($value["id"] == $url[-1]){
                foreach(array_keys($value) as $jsonKey) {
                    foreach (array_keys($jsonData) as $dataKey) {
                        if ($jsonKey == $dataKey) {
                            $json[$key][$jsonKey] = $jsonData[$dataKey];
                        }
                    }
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
$filename = 'animals.json';;
$json = file_get_contents($filename);
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
        file_put_contents($filename,json_encode($list));
        break;
    case "PUT":
        updateId($list, $url, $path, $data);
        file_put_contents($filename,json_encode($list));
        break;
}
