<?php

namespace plugin\jicang\app\controller\system;

use plugin\jicang\annotation\LogInfo;
use plugin\jicang\annotation\UsePermission;
use plugin\jicang\app\service\system\DeptService;
use plugin\jicang\app\validate\system\DeptValidate;
use plugin\jicang\basic\BasicController;
use plugin\jicang\utils\ApiResult;
use support\Request;
use support\Response;

#[LogInfo(name: "部门管理")]
class DeptController extends BasicController
{
    public function __construct()
    {
        $this->validate = new DeptValidate();
        $this->service = new DeptService($this->validate);
        parent::__construct();
    }

    public function list(Request $request):Response
    {
        $params = $this->validate->run('search', $request->get());
        $ret = $this->service->getListWithoutPage($params, []);
        return ApiResult::success($ret);
    }

    #[UsePermission("system:common:query")]
    public function excludeList(Request $request):Response
    {
        $deptId = $request->get('deptId');
        $ret = $this->service->getListWithoutPage([], []);
        $list = $ret;
        if (!empty($deptId)) {
            $items = [];
            foreach ($ret as $v) {
                if ($v['dept_id'] == $deptId || in_array($deptId, explode(',', $v['ancestors']))) {
                    continue;
                }
                $items[] = $v;
            }
            $list = $items;
        }
        return ApiResult::success($list);
    }
}