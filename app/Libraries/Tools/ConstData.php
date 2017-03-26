<?php
/**
 * User: keith.wang
 * Date: 17-3-26
 */

namespace App\Libraries\Tools;


class ConstData
{

    static $GroupNormal = "normal";
    static $GroupForbid = "forbid";
    static $GroupStatus = [];
}


ConstData::$GroupStatus = [ConstData::$GroupNormal,ConstData::$GroupForbid];