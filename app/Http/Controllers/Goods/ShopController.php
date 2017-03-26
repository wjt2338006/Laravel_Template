<?php
/**
 * User: keith.wang
 * Date: 17-3-25
 */

namespace App\Http\Controllers\Goods;


use App\Http\Controllers\Controller;
use App\Libraries\Tools\Permission\Permission;
use App\Model\Goods\Shop;
use Illuminate\Support\Facades\Request;

class ShopController extends Controller
{
    public function detail()
    {
        $user_auth = session("user_auth",null);
        $id = $user_auth["shop_id"];
        $shop = new Shop($id);
        $data = $shop->getData();
        return response()->json($data);

    }
    public function update()
    {
        $user_auth = session("user_auth",null);
        $id = $user_auth["shop_id"];
        $shop = new Shop($id);
        $data = $shop->getData();
        return response()->json($data);
    }


}