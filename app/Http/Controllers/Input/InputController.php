<?php
namespace App\Http\Controllers\Input;

use App\Http\Controllers\Controller;
use App\Libraries\Tools\ModelExtend\Helper;
use App\Repositories\Input\InputMap;
use Illuminate\Support\Facades\Request;

/**
 * User: keith.wang
 * Date: 17-1-9
 */
class InputController extends Controller
{
    public function input($map)
    {
        try
        {
            $param = Request::input("param");


            //检查权限 如果有,并生成权限


            $param["api"] = 'pushJdData';
            $response = InputMap::$map[$param["api"]]($param["args"]);


            return response()->json($response);
        }
        catch(\Exception $e)
        {
            return response()->json(["stats"=>500,"message"=>Helper::handleException("input error:",$e,true)]);
        }


    }

}