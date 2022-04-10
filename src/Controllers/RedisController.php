<?php
require_once (__DIR__.'/../Services/Redis.php');
class CacheController
{
    public function setExCache(string $value)
    {
        echo "in";
        $cache = new Cacher();
        $cache->setEx($value);
    }

    public function invalidCache(string $key="all_data")
    {
        $cache = new Cacher();
        $cache->invalid($key);
    }
}