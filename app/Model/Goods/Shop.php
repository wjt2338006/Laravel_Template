<?php
namespace App\Model\Goods;
use App\Libraries\Exception\LogicException;
use App\Libraries\Tools\ModelExtend\ModelExtend;

/**
 * User: keith.wang
 * Date: 17-1-10
 */

class Shop extends ModelExtend
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
    static protected $table = "shop";

    /**
     * 定义主键名
     * @var
     */
    static protected $primaryKey = "shop_id";


    public static function add($data)
    {
        $data["updated_at"] = time();
        return parent::add($data);
    }

    public function resetPassword($oldPassword,$newPassword,$loginId)
    {
        $data = ModelExtend::select([":login_id"=>$loginId,"first"=>true],"mysql.shop_login.login_id")["data"];
        if(empty($data))
        {
            throw  new LogicException("不存在该用户");
        }

        if($data["login_passwd"] != md5($oldPassword))
        {
            throw  new LogicException("旧密码错误");
        }
        $n = static::getBuilder('mysql.shop_login.login_id',true)->where("login_id",$loginId)->update(["updated_at"=>time(),"login_passwd"=>md5($newPassword)]);
        if($n == 0)
        {
            throw  new LogicException("修改失败");
        }
    }



}