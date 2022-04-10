<?php
require_once(__DIR__ . "/../Models/Animal.php");
require_once(__DIR__ . "/../Controllers/AnimalController.php");

class RequestHandler
{
    public function handle()
    {
        $url = $_SERVER['REQUEST_URI'];
        $path = parse_url($url, PHP_URL_PATH);
        $data = file_get_contents('php://input');

        $controller = new AnimalController();

        $this->determineHTTPMethod($controller, $url, $path, $data);
    }

    public function determineHTTPMethod(AnimalController $controller, string $url, string $path, $data)
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                $controller->getAnimal($url, $path);
                break;

            case  "DELETE":
                $animal = new Animal;
                $animal = $animal->find(intval($url[-1]));
                $controller->deleteId($animal);
                break;

            case "POST":
                $controller->addAnimal($data);
                break;

            case "PUT":
                $animal = new Animal;
                $animal = $animal->find(intval(substr($path,8)));
                $controller->updateId($data, $animal);
                break;
        }
    }
}