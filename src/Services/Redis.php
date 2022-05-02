<?php

require_once(__DIR__ . "/../Helpers/helpers.php");

const KEY = "all_data";

class Cache
{

    public function getConnection(Redis $redis)
    {
        $redis->connect(env("REDIS_HOSTNAME"));
    }

    public function setEx(string $value, int $time = 1800, string $key = KEY)
    {
        $redis = new Redis();

        $this->getConnection($redis);

        $redis->setex($key, $time, $value);
    }

    public function invalid(string $key = "all_data")
    {
        $redis = new Redis();

        $this->getConnection($redis);

        $redis->del($key);
    }

    public function get(string $key = "all_data")
    {
        $redis = new Redis();

        $this->getConnection($redis);

        return $redis->get($key);
    }

}