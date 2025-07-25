<?php

namespace plugin\jicang\app\service\system;

use plugin\jicang\app\model\system\DictTypeModel;
use plugin\jicang\basic\BasicService;
use plugin\jicang\exception\ApiException;

class DictTypeService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new DictTypeModel();
        parent::__construct($validate);
    }

    public function beforeDelete($id)
    {
        $id = parent::beforeDelete($id);
        $dictDataService = new DictDataService();
        foreach ($id as $val) {
            $info = $this->model->find($val);
            if (!empty($info)) {
                $count = $dictDataService->buildQuery([], ['dict_type', $info->dict_type])->count();
                if ($count > 0) {
                    throw new ApiException($info->dictName . "已分配，不能删除");
                }
            }
        }
        return $id;
    }
}