<?php
namespace App\Model\Goods;
use App\Libraries\Tools\ModelExtend\ModelExtend;

/**
 * User: keith.wang
 * Date: 17-1-10
 */

class Goods extends ModelExtend
{
    /**
     * 定义模型数据库连接
     * @var
     */
    static protected $connection = "mysql";

    /**
     * 定义表
     * @var
     */
    static protected $table = "goods";

    /**
     * 定义主键名
     * @var
     */
    static protected $primaryKey = "goods_id";

    public static function selectExtra(&$queryLimit, $query)
    {
        $queryLimit["resultConvert"] = function(&$data){
//            dump($data);
            $data["updated_at"] = ModelExtend::timeToSecondStr($data["updated_at"] );
            $data["goods_spider_time"] = ModelExtend::timeToSecondStr($data["goods_spider_time"] );
        };
        if(!empty($queryLimit["goods_name"]))
        {
            $query->where("goods_name","like","%".$queryLimit["goods_name"]."%");
        }
        if(!empty($queryLimit["goods_id"]))
        {
            $query->where("goods_id",$queryLimit["goods_id"]);
        }
    }



}