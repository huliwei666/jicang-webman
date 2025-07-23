<?php

namespace plugin\jicang\app\controller\system;

use plugin\jicang\annotation\LogInfo;
use plugin\jicang\app\service\system\PostService;
use plugin\jicang\app\validate\system\PostValidate;
use plugin\jicang\basic\BasicController;

#[LogInfo(name: "岗位管理")]
class PostController extends BasicController
{
    public function __construct()
    {
        $this->validate = new PostValidate();
        $this->service = new PostService($this->validate);
        parent::__construct();
    }

}