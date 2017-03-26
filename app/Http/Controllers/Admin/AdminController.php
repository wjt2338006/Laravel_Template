<?php
/**
 * User: keith.wang
 * Date: 17-3-25
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Libraries\Tools\Permission\Permission;
use Illuminate\Support\Facades\Request;

class AdminController extends Controller
{
    public function get()
    {
        $params = Request::input("params");
        $params = json_decode($params,true);
        $result = Permission::getAdmin($params);
        return response()->json(["status"=>200,"message"=>"获得用户数据","data"=>$result]);
    }


}