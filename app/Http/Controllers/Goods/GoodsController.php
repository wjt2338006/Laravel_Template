<?php
/**
 * User: keith.wang
 * Date: 17-3-25
 */

namespace App\Http\Controllers\Goods;


use App\Http\Controllers\Controller;
use App\Libraries\Tools\ModelExtend\ModelExtend;
use App\Libraries\Tools\Permission\Permission;
use App\Model\Goods\Goods;
use Illuminate\Support\Facades\Request;

class GoodsController extends Controller
{
    public function get()
    {
        $params = Request::input("params",[]);
        $params = json_decode($params,true);
        $params["link"] = [
            "appear",
            "goods_id",
            "appear.appear_id"
        ];

        $res = Goods::select($params);
        return response()->json($res);
    }

    public function detail($id)
    {
        $user_auth = session("user_auth", null);
        $gid = $user_auth["shop_id"];
        $data = Goods::select([
            ":goods_shop" => $gid,
            ":goods_id" => $id,
            "first" => true,
            "link" => [
                "appear",
                "goods_id",
                "appear.appear_id",
                [
                    "task",
                    "appear_task",
                    "task.task_id",
                    ["first" => true]
                ]
            ]
        ]);
        return response()->json($data);
    }

    public function appear()
    {

    }


}