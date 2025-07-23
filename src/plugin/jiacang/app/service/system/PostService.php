<?php

namespace plugin\jicang\app\service\system;

use plugin\jicang\app\model\system\PostModel;
use plugin\jicang\basic\BasicService;

class PostService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new PostModel();
        parent::__construct($validate);
    }

}