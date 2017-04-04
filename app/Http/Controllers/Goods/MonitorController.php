<?php
/**
 * User: keith.wang
 * Date: 17-3-25
 */

namespace App\Http\Controllers\Goods;


use App\Http\Controllers\Controller;
use App\Libraries\Tools\ModelExtend\ModelExtend;
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
        $params = json_decode($params, true);
        $params[":watch_shop"] = $id;

        $params = ["link" => [null, "watch_shop", "shop.shop_id"],"resultConvert"=>function(&$dataArray){
            $dataArray["watch_deadline"] = ModelExtend::timeToSecondStr($dataArray["watch_deadline"]);
            $dataArray["watch_last_update"] = ModelExtend::timeToSecondStr($dataArray["watch_last_update"] );
            $dataArray["updated_at"] = ModelExtend::timeToSecondStr($dataArray["updated_at"]);
        }];
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
        return response()->json(["status" => 200, "message" => "得到详情", "data" => $m->getData()]);

    }

    public function add()
    {
        $input = Request("params");
        $user_auth = session("user_auth", null);
        $id = $user_auth["shop_id"];
        $addData["watch_shop"] = $id;
        $addData["watch_index"] = $input["watch_index"];
        $addData["watch_cycle"] = $input["watch_cycle"]*60*60;
        $addData["watch_deadline"] = time() + $addData["watch_cycle"];
        $dataArray["watch_last_update"] = time();

        $model = Monitor::add($addData);
        return response()->json(["status" => 200, "message" => "添加成功", "data" => $model->getId()]);
    }

    public function delete($monitorId)
    {
        $user_auth = session("user_auth", null);
        $id = $user_auth["shop_id"];

        $m = new  Monitor($monitorId);
        if ($m->getData()["watch_shop"] != $id) {
            throw  new \Exception("permission denied!");
        }
        $m->delete();
        return response()->json(["status" => 200, "message" => "删除完成"]);
    }


}