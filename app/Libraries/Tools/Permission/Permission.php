<?php
namespace App\Libraries\Tools\Permission;

use Illuminate\Support\Facades\Session;

/**
 * User: keith.wang
 * Date: 17-1-5
 */
class Permission
{
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

}