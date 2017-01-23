<?php
namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;

/**
 * User: keith.wang
 * Date: 17-1-22
 */
class IndexController extends Controller
{
    public function index()
    {
        return view("admin.index");
    }

}