<?php

namespace plugin\jicang\app\service\system;

use plugin\jicang\app\model\system\DictDataModel;
use plugin\jicang\basic\BasicService;

class DictDataService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new DictDataModel();
        parent::__construct($validate);
    }
    public function selectDictDataListByType($dictType)
    {
        return $this->model::where('dict_type', $dictType)
            ->where('status', 1)
            ->orderBy('dict_sort')
            ->get()
            ->toArray();
    }
}