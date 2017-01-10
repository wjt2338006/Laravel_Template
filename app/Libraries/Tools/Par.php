<?php
/**
 * User: keith.wang
 * Date: 16-12-22
 */

namespace App\Libraries\Tools;


class Par
{
    protected $unit;

    public function __construct(callable $a)
    {
        $this->unit = $a;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public static function run(Par $a)
    {
        $r = $a->getUnit();
        return $r();
    }

    public static function mapList(array $parList, callable $complexFunc = null) //组合多个Par任务到一个新的Par
    {
        if ($complexFunc == null)
        {
            $complexFunc = function ($now, $other)
            {
                return $now;
            };
        }
        return new Par(function () use (&$parList, $complexFunc)
        {
            $now = null;
            foreach ($parList as $singlePar)
            {
                $now = $complexFunc($now, static::run($singlePar));
            }
            return $now;
        });
    }

}