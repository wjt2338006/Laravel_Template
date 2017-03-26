<?php
/**
 * User: keith.wang
 * Date: 17-3-25
 */

namespace App\Http\Controllers\Goods;


use App\Http\Controllers\Controller;
use App\Libraries\Tools\Permission\Permission;
use App\Model\Goods\Monitor;
use Illuminate\Support\Facades\Request;

class MonitorController extends Controller
{
    public function get()
    {
        $user_auth = session("user_auth", null);
        $id = $user_auth["shop_id"];

        $params = Request::input("params");
        $params[":watch_shop"] = $id;
        $data = Monitor::select($params);

        return response()->json($data);
    }


    public function detail($monitorId)
    {
        $user_auth = session("user_auth", null);
        $id = $user_auth["shop_id"];

        $m = new  Monitor($monitorId);
        if ($m->getData()["watch_shop"] != $id) {
            throw  new \Exception("permission denied!");
        }
        return response()->json(["status"=>200,"message"=>"得到详情","data"=>$m->getData()]);

    }

    public function add()
    {
        $user_auth = session("user_auth", null);
        $id = $user_auth["shop_id"];
        $addData[":watch_shop"] = $id;
        $model = Monitor::add($addData);
        return response()->json(["status"=>200,"message"=>"添加成功","data"=>$model->getId()]);
    }


}