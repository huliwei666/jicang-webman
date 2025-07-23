<?php

namespace plugin\jicang\app\service\system;

use plugin\jicang\app\model\system\RoleDeptModel;
use plugin\jicang\basic\BasicService;

class RoleDeptService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new RoleDeptModel();
        parent::__construct($validate);
    }
    public function batchInsertRoleDept($batchData)
    {
        return $this->model::insert($batchData);
    }
    public function deleteRoleDeptByRoleIds($roleIds)
    {
        $roleIds = parent::beforeDelete($roleIds);
        return $this->model->whereIn('role_id', $roleIds)->delete();
    }

}