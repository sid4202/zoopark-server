<?php
require_once(__DIR__ . "/../../.env");

class EnvParser
{

    public static function parse()
    {
        $data = file_get_contents('.env');
        $strings = preg_split("~\n~", $data);
        $env = [];

        foreach ($strings as $string) {
            $vars = preg_split("~=~", $string);
            $env[$vars[0]] = $vars[1];
        }

        return $env;
    }


    public static function env(string $key)
    {
        return self::parse()[$key];
    }
}