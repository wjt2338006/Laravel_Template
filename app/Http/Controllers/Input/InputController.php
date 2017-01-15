<?php
namespace App\Http\Controllers\Input;

use App\Http\Controllers\Controller;
use App\Libraries\Tools\ModelExtend\Helper;

use App\Repositories\Input\InputMap;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

/**
 * User: keith.wang
 * Date: 17-1-9
 */
class InputController extends Controller
{
    public function input()
    {
        try
        {
            $data = Request::all();
            Log::info(json_encode($data));

            $param = Request::input("param");


            //检查权限 如果有,并生成权限

            $api = $param["api"];
            $func = InputMap::get($api);
            $response = $func($param["args"]);

            return response()->json($response);
        }
        catch(\Exception $e)
        {
            $error =["status"=>500,"message"=>Helper::handleException("input error:",$e,true)];

            Log::error(json_encode($error));
            return response()->json($error);
        }


    }

}