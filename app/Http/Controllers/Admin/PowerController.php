<?php
/**
 * User: keith.wang
 * Date: 17-3-25
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Libraries\Tools\ConstData;
use App\Libraries\Tools\ModelExtend\ModelExtend;
use App\Libraries\Tools\Permission\Permission;
use Illuminate\Support\Facades\Request;

class PowerController extends Controller
{
    public function get()
    {
        $params = Request::input("params");
        $params = json_decode($params, true);
        $result = Permission::getGroup($params["group_id"], $params["group_name"]);
        if (!isset($result[0])) {
            $new = [];
            $new[0] = $result;
            $result = $new;
        }
        return response()->json(["status" => 200, "message" => "获得数据", "data" => $result]);
    }

    public function detail($id)
    {

        $result = Permission::getGroup($id);
        return response()->json(["status" => 200, "message" => "获得权限组数据", "data" => $result]);
    }

    public function add()
    {
        $params = Request::input("params");
        $id = Permission::add($params);
        return response()->json(["status" => 200, "message" => "添加成功", "data" => $id]);
    }

    public function update()
    {
        $params = Request::input("params");
        $permit = $params["permit"];
        ModelExtend::filter($params, [
            "group_id",
            "group_status"=> "required",
            "permission_max_people",
            "group_name" => "required",
        ]);
        if(!in_array($params["group_status"] ,ConstData::$GroupStatus))
        {
            throw new \Exception("group status is error");
        }

        Permission::updateGroup($params["group_id"],$params);
        Permission::updateRePermit($params["group_id"],$permit);
        return response()->json(["status" => 200, "message" => "更新成功"]);

    }

    public function del()
    {

    }

    public function getAllPermit()
    {
        $p = Permission::getPermit();
        return response()->json(["status" => 200, "message" => "获取所有权限数据", "data" => $p]);
    }


}