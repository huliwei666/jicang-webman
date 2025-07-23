<?php

namespace plugin\jicang\app\service\system;

use plugin\jicang\app\model\system\UserPostModel;
use plugin\jicang\basic\BasicService;

class UserPostService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new UserPostModel();
        parent::__construct($validate);
    }

}