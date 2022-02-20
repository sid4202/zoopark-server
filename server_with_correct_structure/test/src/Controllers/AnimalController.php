<?php
require_once (__DIR__."/../Models/Animal.php");
require_once (__DIR__."/../Services/getMaxId.php");
require_once(__DIR__."/../Helpers/helpers.php");
class AnimalController
{
    public function getAnimal(string $url, string $path)
    {
        echo substr($path,8);
        $model = new Animal;

        if ($path == "/animals") {
            echo json_encode($model->all());
        }

        if ($path == "/animal/" . substr($path,8)) {
            echo json_encode($model->find(intval(substr($path,8))));
        }

    }

    public function deleteId($object)
    {
        $object->delete();
    }

    function addAnimal($data)
    {
        $jsonData = json_decode($data, true);
        $id = new RequestMaxId();
        $maxId = $id->getMaxId();
        $jsonData['id'] = $maxId + 1;
        $animal = new Animal;
        $animal->create($jsonData);
    }

    function updateId($data, Animal $object)
    {
        $jsonData = json_decode($data, true);
        $jsonData = fillArray($jsonData);
        $object->update($jsonData['name'], $jsonData['type'], $jsonData['age']);
    }
}