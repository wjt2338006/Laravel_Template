<?php
namespace App\Repositories\Input;

use App\Model\Jd;

/**
 * User: keith.wang
 * Date: 17-1-9
 */
class InputMap
{
    static public $map = [];
    public static function init()
    {
        static::$map = [
            "pushJdData" => function ($params)
            {
                Jd::filter($params,[
                    "data_name"=>"required",
                    "data_price"=>"required",
                    "data_detail_url"=>"required",
                    "data_jd_id"=>"required",
                    "data_seller_name"=>"required",
                    "data_order"

                ]);
                $md = Jd::add($params);
                return ["status"=>200,"message"=>"add success!"];
            }
        ];
    }
    public static function get($api)
    {
        return static::$map[$api];
    }

}

InputMap::init();

/*
 * 共用参数
 * api  制定要访问的方法
 * params 参数列表，一个数组
 *
 * key  指定授权码（可选）
 *
 *
 */