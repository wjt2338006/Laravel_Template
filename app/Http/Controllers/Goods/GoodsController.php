<?php
use App\Http\Controllers\Controller;
use App\Libraries\Tools\ModelExtend\ModelExtend;

/**
 * User: keith.wang
 * Date: 17-1-9
 */
class GoodsController extends  Controller
{
    /**
     *
     */
    public function getGoods()
    {
        $data = ModelExtend::select(["desc"=>true],"mysql.spider_jd_data");
        response()->json($data);
    }

}