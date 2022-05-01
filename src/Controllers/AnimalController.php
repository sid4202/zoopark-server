<?php
require_once(__DIR__ . "/../Services/Redis.php");
require_once(__DIR__ . "/../Models/Animal.php");
require_once(__DIR__ . "/../Services/RequestMaxId.php");
require_once(__DIR__ . "/../Helpers/helpers.php");

class AnimalController
{
    public function getAnimal(string $path)
    {
        $model = new Animal;
        $redis = new Cache;

        if ($path == "/animals") {
            if ($redis->get())
                echo $redis->get();
            else {
                echo json_encode($model->all());
                $redis->setEx(json_encode($model->all()));
            }
        }

        if ($path == "/animal/" . substr($path, 8)) {
            echo $model->toJson($model->find(intval(substr($path, 8))));
        }

    }

    public function deleteId($object)
    {
        $object->delete();

        $redis = new Cache;
        $redis->invalid();
    }

    public function deleteAll($object)
    {
        $object->delete_everything();

        $redis = new Cache;
        $redis->invalid();

    }


    function addAnimal($data)
    {
        $jsonData = json_decode($data, true);

        $id = new RequestMaxId();
        $maxId = $id->getMaxId();
        $jsonData['id'] = $maxId + 1;

        $animal = new Animal;
        $animal->create($jsonData);

        $redis = new Cache;
        $redis->invalid();

    }

    function updateId($data, Animal $object)
    {
        $jsonData = json_decode($data, true);
        fillArray($jsonData);

        $object->update($jsonData['name'], $jsonData['type'], $jsonData['age']);

        $redis = new Cache;
        $redis->invalid();
    }
}