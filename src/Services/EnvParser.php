<?php


class EnvParser
{
    public static $instance;
    public $env;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new EnvParser();
        }
        return self::$instance;
    }

    public function parse()
    {
        if ($this->env === null) {
            $data = file_get_contents('.env');
            $strings = preg_split("~\n~", $data);
            $this->env = [];

            foreach ($strings as $string) {
                $vars = preg_split("~=~", $string);
                $this->env[$vars[0]] = $vars[1];
            }
        }
        return $this->env;
    }

}

