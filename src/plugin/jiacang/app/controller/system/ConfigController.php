<?php

namespace plugin\jicang\app\controller\system;

use plugin\jicang\annotation\LogInfo;
use plugin\jicang\annotation\UsePermission;
use plugin\jicang\app\service\system\ConfigService;
use plugin\jicang\app\validate\system\ConfigValidate;
use plugin\jicang\basic\BasicController;
use plugin\jicang\utils\ApiResult;
use support\Request;
use support\Response;

#[LogInfo(name: "参数管理")]
class ConfigController extends BasicController
{
    public function __construct()
    {
        $this->validate = new ConfigValidate();
        $this->service = new ConfigService($this->validate);
        parent::__construct();
    }

    #[UsePermission("system:common:query")]
    public function keyInfo(Request $request): Response
    {
        $configKey = $request->get('configKey', '');
        $ret = $this->service->getKeyInfo($configKey);
        return ApiResult::success($ret);
    }
}