<?php

namespace plugin\jicang\app\controller\system;

use plugin\jicang\annotation\LogInfo;
use plugin\jicang\annotation\UsePermission;
use plugin\jicang\app\service\system\DictTypeService;
use plugin\jicang\app\validate\system\DictTypeValidate;
use plugin\jicang\basic\BasicController;
use plugin\jicang\utils\ApiResult;
use support\Request;
use support\Response;

#[LogInfo(name: "字典管理")]
class DictTypeController extends BasicController
{
    public function __construct()
    {
        $this->validate = new DictTypeValidate();
        $this->service = new DictTypeService($this->validate);
        parent::__construct();
    }

    #[UsePermission("system:common:query")]
    public function optionSelectList(Request $request):Response
    {
        $ret = $this->service->getListWithoutPage([]);
        return ApiResult::success($ret);
    }

}