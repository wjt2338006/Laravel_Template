<?php
/**
 * User: keith.wang
 * Date: 17-3-25
 */

namespace App\Http\Controllers\Goods;


use App\Http\Controllers\Controller;
use App\Libraries\Tools\ModelExtend\ModelExtend;
use App\Libraries\Tools\Permission\Permission;
use App\Model\Goods\Shop;
use Illuminate\Support\Facades\Request;

class ShopController extends Controller
{
    public function detail()
    {
        $user_auth = session("user_auth", null);
        $id = $user_auth["shop_id"];

        $data = Shop::select([
            ":shop_id" => $id,
            "link" => [
                null,
                "shop_group",
                "watch_group.group_id"
            ],
            "first"=>true
        ])["data"];

        return response()->json(["status" => 200, "data" => $data]);

    }

    public function update()
    {
        $user_auth = session("user_auth", null);
        $id = $user_auth["shop_id"];
        $params = Request::input("params");

        $shop = new Shop($id);
        if ($shop->getData()["shop_id"] != $id) {
            throw new \Exception("Permission Denied");
        }

        $shop->update($params);
        return response()->json(["status" => true, "message" => "完成"]);
    }
    public function resetPassword()
    {
        $params = Request::input("params",[]);
        ModelExtend::filter($params,[
            "old_password"=>"required",
            "password"=>"required",
            "confirm_password"=>"required"
        ]);

        $user_auth = session("user_auth", null);
        $sid = $user_auth["shop_id"];
        $lid = $user_auth["login_id"];
        if($params["password"]!=$params["password_confirm"])
        {
            throw new \Exception("新旧密码不一致");
        }

        $shop = new Shop($sid);
        $shop->resetPassword($params["old_password"],$params["password"],$lid);
        return response()->json(["status" => 200, "message" => "新密码已经设置"]);
    }



}