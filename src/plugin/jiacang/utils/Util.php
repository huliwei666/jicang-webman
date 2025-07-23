<?php

namespace plugin\jicang\utils;

use plugin\jicang\exception\ApiException;
use support\Db;
use support\Redis;

class Util
{
    public static function getDb($connection = null)
    {
        return Db::connection($connection ?: 'plugin.jicang.mysql');
    }

    public static function getRedis($connection = null)
    {
        return Redis::connection($connection ?: 'plugin.jicang.default');
    }
}