<?php

namespace plugin\jicang\app\service\system;

use plugin\jicang\app\model\system\UserRoleModel;
use plugin\jicang\basic\BasicService;

class UserRoleService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new UserRoleModel();
        parent::__construct($validate);
    }

}