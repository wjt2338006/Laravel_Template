<?php
/**
 * User: keith.wang
 * Date: 17-3-25
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Libraries\Tools\Permission\Permission;
use Illuminate\Support\Facades\Request;

class PowerController extends Controller
{
    public function get()
    {
        $params = Request::input("params");
        $params = json_decode($params,true);
        $result = Permission::getGroup($params["group_id"],$params["group_name"]);
        if(!isset($result[0]) )
        {
            $new = [];
            $new[0] = $result;
            $result = $new;
        }
        return response()->json(["status"=>200,"message"=>"获得数据","data"=>$result]);
    }

    public function detail($id)
    {

        $result = Permission::getGroup($id);
        return response()->json(["status"=>200,"message"=>"获得数据","data"=>$result]);
    }

    public function add()
    {
        $params = Request::input("params");
        $id = Permission::add($params);
        return response()->json(["status"=>200,"message"=>"添加成功","data"=>$id]);
    }

    public function update()
    {

    }

    public function del()
    {

    }

    public function getAllPermit()
    {
        $p = Permission::getPermit();
        return response()->json(["status"=>200,"message"=>"获取所有权限数据","data"=>$p]);
    }


}