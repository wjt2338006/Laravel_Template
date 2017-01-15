<?php
/**
 * User: keith.wang
 * Date: 17-1-13
 */

namespace App\Model;


use App\Libraries\Tools\ModelExtend\ModelExtend;

class OriginPage extends ModelExtend
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
    static protected $table = "spider_origin_page";

    /**
     * 定义主键名
     * @var
     */
    static protected $primaryKey = "page_id";


}