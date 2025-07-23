<?php

namespace plugin\jicang\app\controller\monitor;

use plugin\jicang\annotation\LogInfo;
use plugin\jicang\app\service\monitor\OperLogService;
use plugin\jicang\app\validate\monitor\OperLogValidate;
use plugin\jicang\basic\BasicController;
use plugin\jicang\utils\ApiResult;
use support\Request;
use support\Response;

#[LogInfo(name: "操作日志管理")]
class OperLogController extends BasicController
{
    public function __construct()
    {
        $this->validate = new OperLogValidate();
        $this->service = new OperLogService($this->validate);
        parent::__construct();
    }

    public function allRemove(Request $request):Response
    {
        return $this->service->allRemove() ? ApiResult::success() : ApiResult::error();
    }
}