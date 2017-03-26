<?php
namespace App\Libraries\Tools\Permission;

use Illuminate\Support\Facades\Session;

/**
 * User: keith.wang
 * Date: 17-1-5
 */
class Permission
{
    /*
     * admin_auth
     * |-权限字段
     * |-permit 详细权限
     * |-admin_id
     * |-admin_username
     * user_auth
     * |-shop_id
     * |-login_id
     *
     */
    public static function check($permissionId)
    {
        $auth = session("admin_auth",null);
        if(!empty($auth["permit"]))
        {
            foreach ($auth["permit"] as $permit)
            {
                if($permit["re_permission_id"] == $permissionId)
                {
                    return true;
                }
            }

        }
        return false;
    }

    public function __construct($groupId)
    {
        $this->power = MysqlStore::getGroup($groupId);
        if(empty($this->power))
        {
            throw  new \Exception("no auth group !");
        }
        unset($this->power["permission_max_people"]);
    }


    public function setSession()
    {
        session(["admin_auth"=>$this->power]);

    }
    public static function clean()
    {
        session(["admin_auth"=>null]);
    }
    public static function getGroup($id = null,$name=null)
    {

        return MysqlStore::getGroup($id,$name);
    }

    public static function add($data)
    {
        return MysqlStore::addGroup($data);
    }
    public static function updateGroup($id,$data)
    {
        return MysqlStore::updateGroup($id,$data);
    }

    public static function getPermit()
    {
        return MysqlStore::getPermit();
    }
    public static function updateRePermit($id,$data)
    {
        return MysqlStore::updateRePermit($id,$data);
    }


    public static function  getAdmin($limit)
    {
        return MysqlStore::getAdmin($limit);
    }

}