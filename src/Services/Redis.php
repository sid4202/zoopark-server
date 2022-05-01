<?php
require_once (__DIR__."/EnvParser.php");
class Cache
{

    public function getConnection(Redis $redis)
    {
        $redis->connect(EnvParser::env("REDIS_HOSTNAME"));
    }

    public function setEx(string $value, int $time = 1800, string $key = "all_data")
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