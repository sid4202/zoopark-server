<?php
require_once "fill-data.php";
function getAnimal($url, $path, $animalTable, $link)
{
    if ($path == "/animals") {
        echo json_encode($animalTable->all($link));
    }
    if ($path == "/animal/" . $url[-1]) {
        echo json_encode($animalTable->find(intval($url[-1]), $link));
    }
}

function deleteId($link, $object)
{
    $object->delete($link);
}

function addAnimal($link, $data, $object)
{
    $jsonData = json_decode($data, true);
    $maxId = $object->getMaxId($link);
    $jsonData['id'] = $maxId + 1;
    echo $maxId;
    $object->create($jsonData, $link);
}

function updateId($link, $data, $object)
{
    $jsonData = json_decode($data, true);
    fillArray($jsonData);
    var_dump($jsonData);
    $object->update($link, $jsonData['name'], $jsonData['type'], $jsonData['age']);
}