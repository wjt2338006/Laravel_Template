<?php
namespace App\Http\Controllers\Basic\Goods;

use App\Http\Controllers\Controller;
use App\Model\Jd;

/**
 * User: keith.wang
 * Date: 17-1-23
 */
class GoodsController extends Controller
{
    public function getGoodsData()
    {
        $data = Jd::select([]);
        return response()->json($data);
    }
}