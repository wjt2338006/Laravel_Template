<?php
/**
 * User: keith.wang
 * Date: 17-1-5
 */

namespace App\Libraries\Tools\Permission;


interface DataStore
{
    public static function getGroup($id = null);

    public static function addGroup($data);

    public static function updateGroup($id, $data);

    public static function deleteGroup($id);

    public static function appendPermitToGroup($groupId,$permitId);

    public static function deletePermitFromGroup($groupId,$permitId);

    public static function getPermit($id = null);
    public static function addPermit($data);
    public static function updatePermit($id ,$data);
    public static function deletePermit($id);
}