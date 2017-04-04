<?php
/**
 * User: keith.wang
 * Date: 17-3-13
 */

namespace App\Http\Controllers\Goods;


use App\Libraries\Tools\ModelExtend\Helper;
use App\Libraries\Tools\ModelExtend\ModelExtend;
use App\Libraries\Tools\Permission\Permission;
use App\Repositories\Goods\Shop;

class AuthController
{
    public function login()
    {
        return view("login");

    }

    public function logout()
    {

        return response()->json(["status" => true]);
    }


    public function requestLogin()
    {
        try {
            $input = Request("params");
            $limit = [
                ":login_name" => $input["username"],
                ":login_passwd" => md5($input["password"]),
            ];
            $data = Shop::get($limit);
            if (empty($data)) {
                return response()->json(["status" => 500, "message" => "登录失败"]);
            }

            session(["user_auth" => $data]);

            return response()->json(["status" => 200, "message" => "登录成功"]);
        } catch (\Exception $e) {
            return response()->json(["status" => 500, "message" => Helper::handleException("错误 + ", $e, true)]);
        }
    }

    public function getUserinfo()
    {
        $user_auth = session("user_auth", null);

        $limit = [
            ":login_shop" => $user_auth["shop_id"],
        ];
        $data = Shop::get($limit);
        return response()->json(["status" => 200, "message" => "用户信息获取成功","data"=>$data]);
    }

}