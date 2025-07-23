<?php

namespace plugin\jicang\app\controller\system;

use plugin\jicang\annotation\LogInfo;
use plugin\jicang\annotation\UsePermission;
use plugin\jicang\app\service\system\DictDataService;
use plugin\jicang\app\validate\system\DictDataValidate;
use plugin\jicang\basic\BasicController;
use plugin\jicang\utils\ApiResult;
use support\Request;
use support\Response;

#[LogInfo(name: "字典数据管理")]
#[UsePermission("system:dictData:manage")]
class DictDataController extends BasicController
{
    public function __construct()
    {
        $this->validate = new DictDataValidate();
        $this->service = new DictDataService($this->validate);
        parent::__construct();
    }

    #[UsePermission("system:common:query")]
    public function all(Request $request):Response
    {
        $dictType = $request->get('dictType', '');
        $data = [$dictType];
        if (!empty($dictType)) {
            $dictDataService = new DictDataService();
            $data = $dictDataService->selectDictDataListByType($dictType);
        }
        return ApiResult::success($data);
    }
}