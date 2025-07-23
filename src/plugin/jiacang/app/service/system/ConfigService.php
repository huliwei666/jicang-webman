<?php

namespace plugin\jicang\app\service\system;

use plugin\jicang\app\model\system\ConfigModel;
use plugin\jicang\basic\BasicService;
use plugin\jicang\constant\Constants;
use plugin\jicang\utils\Util;

class ConfigService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new ConfigModel();
        parent::__construct($validate);
    }

    public function getKeyInfo($configKey)
    {
        $cacheKey = Constants::CONFIG_KEY . $configKey;
        $value = Util::getRedis()->get($cacheKey);
        if (is_null($value)) {
            $ret = $this->model->where('config_key', $configKey)->first();
            $value = $ret ? $ret->config_value : '' ;
            if ($value !== '') {
                $dataCacheExpire = config('plugin.jicang.app.data_cache_expire');
                Util::getRedis()->setex($cacheKey, $dataCacheExpire, $value);
            }
        }
        return $value;
    }

}