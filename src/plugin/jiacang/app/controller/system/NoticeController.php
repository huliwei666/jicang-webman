<?php

namespace plugin\jicang\app\controller\system;

use plugin\jicang\annotation\LogInfo;
use plugin\jicang\app\service\system\NoticeService;
use plugin\jicang\app\validate\system\NoticeValidate;
use plugin\jicang\basic\BasicController;

#[LogInfo(name: "通知公告管理")]
class NoticeController extends BasicController
{
    public function __construct()
    {
        $this->validate = new NoticeValidate();
        $this->service = new NoticeService($this->validate);
        parent::__construct();
    }
}