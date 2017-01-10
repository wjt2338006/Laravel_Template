<?php
namespace App\Repositories\Input;

/**
 * User: keith.wang
 * Date: 17-1-9
 */
class InputMap
{
    static public $map;
    public static function init()
    {
        static::$map = [
            "pushJdData" => function ($params)
            {
                
            }
        ];
    }

}

InputMap::init();

/*
 * 共用参数
 * api  制定要访问的方法
 * params 参数列表，一个数组
 *
 * key  指定授权码（可选）
 *
 *
 */