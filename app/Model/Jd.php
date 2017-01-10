<?php
namespace App\Model;
use App\Libraries\Tools\ModelExtend\ModelExtend;

/**
 * User: keith.wang
 * Date: 17-1-10
 */

class Jd extends ModelExtend
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
    static protected $table = "mysql";

    /**
     * 定义主键名
     * @var
     */
    static protected $primaryKey = "stock_agent_id";

}