<?php

class Cacher
{

    public function getConnection(Redis $redis)
    {
        $redis->connect('127.0.0.1',6379);
    }

    public function setEx(string $value, int $time=1800, string $key = "all_data")
    {
        $redis = new Redis();

        $this->getConnection($redis);

        $redis->setex($key, $time, $value);
        echo $redis->get($key);
    }

    public function invalid(string $key = "all_data")
    {
        $redis = new Redis();

        $this->getConnection($redis);

        $redis->del($key);
    }

}