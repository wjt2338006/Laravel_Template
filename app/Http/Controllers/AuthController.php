<?php
/**
 * User: keith.wang
 * Date: 17-3-13
 */

namespace App\Http\Controllers;


use App\Libraries\Tools\ModelExtend\Helper;
use App\Libraries\Tools\ModelExtend\ModelExtend;
use App\Libraries\Tools\Permission\Permission;

class AuthController
{
    public function login()
    {
        return view("login");

    }
    public function logout()
    {
        Permission::clean();
        return response()->json(["status"=>true]);
    }


    public function requestLogin()
    {
        try{
            $input = Request("params");
            $data = ModelExtend::select([":admin_username" => $input["username"], ":admin_password" => md5($input["password"]),"first"=>true],
                "basic.admin.admin_id")["data"];
            if(empty($data))
            {
                return response()->json(["status"=>500,"message"=>"登录失败"]);
            }

            $p = new Permission($data["admin_group"]);
            $p->setSession();

            $data["shop_id"]= 1 ;
            $data["login_id"]= 1 ;

            session(["user_auth"=>$data]);
            return response()->json(["status"=>200,"message"=>"登录成功"]);
        }
        catch(\Exception $e)
        {
            return response()->json(["status"=>500,"message"=>Helper::handleException("错误 + ",$e,true)]);
        }
    }

}