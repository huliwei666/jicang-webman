<?php

namespace plugin\jicang\app\controller\monitor;

use plugin\jicang\annotation\LogInfo;
use plugin\jicang\app\service\monitor\LogininforService;
use plugin\jicang\app\validate\monitor\LogininforValidate;
use plugin\jicang\basic\BasicController;
use plugin\jicang\utils\ApiResult;
use support\Request;
use support\Response;

#[LogInfo(name: "登录日志管理")]
class LogininforController extends BasicController
{
    public function __construct()
    {
        $this->validate = new LogininforValidate();
        $this->service = new LogininforService($this->validate);
        parent::__construct();
    }
    public function allRemove(Request $request):Response
    {
        return $this->service->allRemove() ? ApiResult::success() : ApiResult::error();
    }

    public function lockRemove(Request $request):Response
    {
        $userName = $request->post('userName');
        if (!empty($userName)) {
            $this->service->unLockUserCache($userName);
        }
        return ApiResult::success();
    }
}