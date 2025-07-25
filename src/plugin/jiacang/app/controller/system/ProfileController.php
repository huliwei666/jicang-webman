<?php

namespace plugin\jicang\app\controller\system;

use plugin\jicang\annotation\LogInfo;
use plugin\jicang\app\service\AuthService;
use plugin\jicang\app\service\system\PostService;
use plugin\jicang\app\service\system\RoleService;
use plugin\jicang\app\service\system\UserPostService;
use plugin\jicang\app\service\system\UserRoleService;
use plugin\jicang\app\service\system\UserService;
use plugin\jicang\basic\BasicController;
use plugin\jicang\utils\ApiResult;
use plugin\jicang\utils\Random;
use support\Request;
use support\Response;

#[LogInfo(name: "个人中心")]
class ProfileController extends BasicController
{
    protected $noNeedAuth = ['*'];

    public function info(Request $request):Response
    {
        $adminInfo = adminInfo();
        $userId = $adminInfo['user_id'];
        $userService = new UserService();
        $user = $userService->getInfo($userId);
        unset($user['password']);
        $userPostService = new UserPostService();
        $userRoleService = new UserRoleService();
        $postService = new PostService();
        $roleService = new RoleService();
        $postIds = $userPostService->buildQuery([], ['user_id', '=', $userId])->pluck('post_id')->toArray();
        $roleIds = $userRoleService->buildQuery([], ['user_id', '=', $userId])->pluck('role_id')->toArray();
        $postNames = $postService->buildQuery(['post_id' => $postIds], [])->pluck('post_name')->toArray();
        $roleNames = $roleService->buildQuery(['role_id' => $roleIds], [])->pluck('role_name')->toArray();
        $ret = [
            'info' => $user,
            'postGroup' => implode(',', $postNames),
            'roleGroup' => implode(',', $roleNames),
        ];
        return ApiResult::success($ret);;
    }

    #[LogInfo(name: "修改基本资料")]
    public function edit(Request $request):Response
    {
        $adminInfo = adminInfo();
        $userId = $adminInfo['user_id'];
        $uuid = $adminInfo['uuid'];

        $nickName = $request->post('nickName', '');
        $email = $request->post('email', '');
        $phonenumber = $request->post('phonenumber', '');
        $sex = $request->post('sex', 0);
        if (!validatorSingle($nickName, 'required|min:1|max:50')) {
            return ApiResult::error("昵称有误");
        }
        if (!validatorSingle($email, 'required|max:50|email')) {
            return ApiResult::error("邮箱有误");
        }
        if (!validatorSingle($phonenumber, 'required|mobile')) {
            return ApiResult::error("手机号有误");
        }
        if (!validatorSingle($sex, 'required|in:0,1,2')) {
            return ApiResult::error("性别有误");
        }
        $userData = [
            'user_id' => $userId,
            'nick_name' => $nickName,
            'email' => $email,
            'phonenumber' => $phonenumber,
            'sex' => $sex,
        ];
        $userService = new UserService();
        $userService->verifyUnique($userData);
        $userService->userUpdate($userData);
        return ApiResult::success();
    }

    #[LogInfo(name: "修改头像")]
    public function avatarEdit(Request $request): Response
    {
        $file = $request->file('avatarfile');
        if ($file && $file->isValid()) {
            if (!in_array(strtolower($file->getUploadExtension()), ['jpg', 'jpeg', 'png'])) {
                return ApiResult::error("只支持'jpg', 'jpeg', 'png'类型文件");
            }
            $uploadPath = config('plugin.jicang.app.upload_path');
            $dir = '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
            $fileName = Random::uuid() . '.' . $file->getUploadExtension();
            $adminInfo = adminInfo();
            //
            $fileData = [
                'extension'     => $file->getUploadExtension(),
                'mime_type'     => $file->getUploadMimeType(),
                'file_name'     => $file->getUploadName(),
                'size'          => $file->getSize(),
                'path'          => $dir . $fileName,
                'create_by'     => $adminInfo['user_id']
            ];
            //

            $file->move($uploadPath . $dir . $fileName);
            $userId = $adminInfo['user_id'];
            $userData = [
                'user_id' => $userId,
                'avatar' => $dir . $fileName,
            ];

            $userService = new UserService();
            $userService->userUpdate($userData);

            return ApiResult::success(['imgUrl' => $dir . $fileName]);
        }
        return ApiResult::error("上传出现错误");
    }

    #[LogInfo(name: "修改密码", withParams: false)]
    public function pwdEdit(Request $request): Response
    {
        $oldPassword = $request->post('oldPassword', '');
        $newPassword = $request->post('newPassword', '');
        if (empty($oldPassword) || empty($newPassword)) {
            return ApiResult::error('新旧密码不能为空');
        }
        $authService = new AuthService();
        $authService->updatePwd($oldPassword, $newPassword);
        return ApiResult::success();
    }
}