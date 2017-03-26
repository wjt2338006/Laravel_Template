<?php
/**
 * User: keith.wang
 * Date: 17-3-25
 */

namespace App\Http\Controllers\Goods;


use App\Http\Controllers\Controller;


class IndexController extends Controller
{
    public function index()
    {
        return view("goods.index");
    }


}