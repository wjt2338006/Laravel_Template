<?php
/**
 * User: keith.wang
 * Date: 17-1-13
 */

namespace App\Repositories\Input;


use App\Model\Log;

class LogData
{
    public static function init()
    {
        return function($args)
        {
            $insert = [
                "log_data"=>$args["data"],
                "log_type"=>$args["type"],
                "log_created"=>time(),
                "log_type_second" =>1
            ];
        };
    }
}