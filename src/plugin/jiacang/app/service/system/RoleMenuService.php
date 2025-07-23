<?php

namespace plugin\jicang\app\service\system;

use plugin\jicang\app\model\system\RoleMenuModel;
use plugin\jicang\basic\BasicService;

class RoleMenuService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new RoleMenuModel();
        parent::__construct($validate);
    }
    public function batchInsertRoleMenu($batchData)
    {
        return $this->model::insert($batchData);
    }

    public function deleteRoleMenuByRoleIds($roleIds)
    {
        $roleIds = parent::beforeDelete($roleIds);
        return $this->model->whereIn('role_id', $roleIds)->delete();
    }
}