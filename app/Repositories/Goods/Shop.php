<?php
namespace App\Repositories\Goods;

use App\Libraries\Tools\ModelExtend\ModelExtend;

/**
 * User: keith.wang
 * Date: 17-4-2
 */
class Shop
{
    public static  function get($extra)
    {
        $limit = [
            "link" => [
                null,
                "login_shop",
                "shop.shop_id",
                [
                    "link" => [
                        [null, "shop_group", "watch_group.group_id"],
                        [null, "shop_id", "shop_watch.watch_shop"]
                    ]
                ]
            ],
            "first" => true,
            "deleteEmpty" =>["shop_id"]
        ];
        $limit = array_merge($limit,$extra);
        $data = ModelExtend::select($limit,
            "shop_login.login_id")["data"];
        if(!empty($data))
        {
            unset($data["login_passwd"]);
        }
        return $data;

    }
}