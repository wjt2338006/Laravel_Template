<?php
/**
 * User: keith.wang
 * Date: 17-1-5
 */

namespace App\Http\Middleware;


use App\Libraries\Tools\Permission\Exception\PermissionDeny;
use App\Libraries\Tools\Permission\Permission;
use Closure;

class Auth
{
    /**
     * @param $request
     * @param Closure $next
     * @param $permissionId //检查是否有这个id的权限
     * @return mixed
     * @throws PermissionDeny
     */
    public function handle($request, Closure $next,$permissionId =null)
    {
        // 执行动作
        if(false!==Permission::check($permissionId))
        {
            return $next($request);
        }
        else
        {
            return redirect()->action('AuthController@login');
        }

    }
}