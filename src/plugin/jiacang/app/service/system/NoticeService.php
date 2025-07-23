<?php

namespace plugin\jicang\app\service\system;

use plugin\jicang\app\model\system\NoticeModel;
use plugin\jicang\basic\BasicService;

class NoticeService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new NoticeModel();
        parent::__construct($validate);
    }

}