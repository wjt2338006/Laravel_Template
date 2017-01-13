<?php
namespace App\Repositories\Input;

use App\Libraries\LogType;
use App\Model\Jd;
use App\Model\Log;

/**
 * User: keith.wang
 * Date: 17-1-9
 */
class InputMap
{
    static private $map = [];

    public static function init()
    {
        static::$map = [
            "pushJdData" => function ($params)
            {
                Jd::filter($params, [
                    "data_name" => "required",
                    "data_price" => "required",
                    "data_detail_url" => "required",
                    "data_jd_id" => "required",
                    "data_seller_name" => "required",
                    "data_order"

                ]);
                if (!empty($haveData = Jd::select([":data_jd_id" => $params["data_jd_id"]])["data"]))
                {
                    $x = new Jd($haveData["data_jd_id"]);
                    $x->update($params);
                }
                else
                {
                    Jd::add($params);
                }

                return ["status" => 200, "message" => "add success!"];
            },
            "pushJdErrorExplain" => function ($args)
            {
                $insert = [
                    "log_data" => $args["data"],
                    "log_type" => LogType::F_JdLog,
                    "log_created" => time(),
                    "log_type_second" => LogType::S_JdErrorExplain
                ];
                Log::add($insert);
                return ["status" => 200, "message" => "add success!"];
            },


        ];
    }

    public static function get($api)
    {
        return static::$map[$api];
    }

    public static function append($key, $function)
    {
        static::$map[$key] = $function;
    }


}

InputMap::init();

/*
 * 共用参数
 * param
 * |-api  制定要访问的方法
 * |-args 参数列表，一个数组
 *
 * |-key  指定授权码（可选）
 *
 *
 */