<?php
/**
 * User: keith.wang
 * Date: 17-1-5
 */

namespace App\Libraries\Tools\Permission;


use App\Libraries\Tools\ModelExtend\ModelExtend;

class MysqlStore implements DataStore
{
    static $groupCon = "basic.permission_group.group_id";
    static $reCon = "basic.permission_group_re_power.re_permission_id";
    static $permitCon = "basic.permission.permission_id";
    static $adminCon = "basic.admin.admin_id";
    public static function getGroup($id = null,$name=null)
    {
        $limit = [
            "link" => [

                "permit",
                "group_id",
                "basic.permission_group_re_power.re_group_id",
                ["link" => [null, "re_permission_id", "basic.permission.permission_id"]]
            ]

        ];

        if (!empty($id))
        {
            $limit[":group_id"] = $id;
            $limit["first"] = true;
        }
        if(!empty($name))
        {
            $limit["custom"] =function($queryLimit,$query)use($name)
            {
                $query->where("group_name","like","%".$name."%");
            };
        }

        $data = ModelExtend::select(
            $limit, static::$groupCon)["data"];
        return $data;
    }

    public static function addGroup($data)
    {
        ModelExtend::filter($data, ["group_name" => "required"]);
        return ModelExtend::getBuilder(static::$groupCon, true)->insertGetId($data);
    }

    public static function updateGroup($id, $data)
    {
        ModelExtend::filter($data, ["group_name" => "required"]);
        return ModelExtend::getBuilder(static::$groupCon, true)->where("group_id", $id)->update($data);
    }

    public static function deleteGroup($id)
    {
        return ModelExtend::getBuilder(static::$groupCon, true)->where("group_id", $id)->delete();
    }

    public static function appendPermitToGroup($groupId, $permitId)
    {
        return ModelExtend::getBuilder(static::$reCon, true)->insertGetId([
            "re_permission_id" => $permitId,
            "re_group_id" => $groupId
        ]);
    }

    public static function deletePermitFromGroup($groupId, $permitId)
    {
        return ModelExtend::getBuilder(static::$reCon, true)->where("re_permission_id",
            $permitId)->where("re_group_id", $groupId)->delete();
    }

    public static function getPermit($id = null)
    {
        $limit = [];
        if (!empty($id))
        {
            $limit[":group_id"] = $id;
        }
        return ModelExtend::select($limit,static::$permitCon)["data"];
    }

    public static function addPermit($data)
    {
        ModelExtend::filter($data, ["power_name" => "required"]);
        return ModelExtend::getBuilder(static::$permitCon, true)->insertGetId($data);
    }

    public static function updatePermit($id ,$data)
    {
        ModelExtend::filter($data, ["power_name" => "required"]);
        return ModelExtend::getBuilder(static::$permitCon, true)->where("permission_id",$id)->update($data);
    }

    public static function deletePermit($id)
    {
        return ModelExtend::getBuilder(static::$permitCon, true)->where("permission_id",
            $id)->where("permission_id", $id)->delete();
    }

    public static function getAdmin($limit)
    {
        $limit["custom"] = function($limit,$q)
        {
            if(isset($limit["group_id"]))
            {
                $limit[":group_id"] = $limit["group_id"];
            }
        };
        return ModelExtend::select($limit,static::$adminCon)["data"];
    }
}