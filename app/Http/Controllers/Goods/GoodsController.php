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
        $params = Request::input("params");
        $res = Goods::select($params);
        return response()->json($res);
    }

    public function detail($id)
    {

        $data = Goods::select([
            ":id" => $id,
            "first" => true,
            "link" => [
                "appear",
                "goods_id",
                "appear.appear_id"
            ]
        ]);
        return response()->json($data);
    }

    public function appear()
    {

    }




}