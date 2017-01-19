<?php
namespace App\Repositories\Input;

use App\Libraries\LogType;
use App\Libraries\PageType;
use App\Libraries\SingleType;
use App\Model\Jd;
use App\Model\Log;
use App\Model\OriginPage;
use App\Model\OriginSingle;
use App\Model\RequestPool;

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

            //发送分析后的商品数据
            "pushJdData" => function ($args)
            {
                Jd::filter($args, [
                    "data_name" => "required",
                    "data_price" => "required",
                    "data_detail_url" => "required",
                    "data_jd_id" => "required",
                    "data_seller_name" => "required",
                    "data_order"

                ]);
                if (!empty($haveData = Jd::select([":data_jd_id" => $args["data_jd_id"], "first" => true])["data"]))
                {
//                    Log::info("旧的数据 update" . $haveData["data_jd_id"]);
                    $x = new Jd($haveData["data_id"]);
                    $x->update($args);
                }
                else
                {
//                    Log::info("新的数据" . $haveData["data_jd_id"]);
                    Jd::add($args);
                }

                return ["status" => 200, "message" => "add success!"];
            },
            //推入错误信息
            "pushJdErrorExplain" => function ($args)
            {
                $insert = [
                    "log_data" => $args["data"],
                    "log_type" => LogType::F_JdLog,
                    "log_created" => time(),
                    "log_type_second" => LogType::S_JdErrorExplain,
                    'log_error_msg' => $args["error_msg"]
                ];
                Log::add($insert);
                return ["status" => 200, "message" => "add success!"];
            },

            //整列表页数据
            "pushJdOriginPage" => function ($args)
            {
                $insert = [
                    "page_url" => $args["page_url"],
                    "page_type" => PageType::Jd_List,
                    "page_data" => $args["page_data"],
                    "created_at" => time(),
                ];
                OriginPage::add($insert);
                return ["status" => 200, "message" => "add success!"];
            },
            //拉取单页信息
            'pullJdOriginPage' => function ($args)
            {
                $type = $args["type"];
                $data = OriginPage::select(["first" => true, ":page_type" => $type, ":consume" => 0]);
                if (!empty($data["data"]))
                {
                    $m = new OriginPage($data["data"]["page_id"]);
                    $m->update(["consume" => 1]);
                }
                return $data;
            },


            //推入单条
            'pushJdOriginSingle' => function ($args)
            {
                $insert = [
                    "single_type" => SingleType::Jd_Goods,
                    "single_other" => json_encode($args["other"]),
                    'single_data' => $args["data"],
                    'created_at' => time()
                ];
                $data = OriginSingle::add($insert);
                return $data;
            },
            //拉单条
            'pullJdOriginSingle' => function ($args)
            {
                $type = $args["type"];
                $data = OriginSingle::select(["first" => true, ":single_type" => $type, ":consume" => 0]);
                if (!empty($data["data"]))
                {
                    $m = new OriginSingle($data["data"]["single_id"]);
                    $m->update(["consume" => 1]);
                }
                return $data;
            },

            //推送一个url到池子
            "pushUrl" => function ($args)
            {
                /*
                 * 传入参数
                 * url
                 * type
                 */
                $insert = [
                    "re_url" => $args["url"],
                    "re_type" => $args["type"]
                ];
                $data = RequestPool::add($insert);
                return ["status" => 200, "message" => "add success!"];
            },
            "pullUrl" => function ($args)
            {
                $type = $args["type"];
                $data = RequestPool::select(["first" => true, ":re_type" => $type]);
                return $data;
            }


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