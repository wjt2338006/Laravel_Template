<?php
/**
 * User: keith.wang
 * Date: 17-1-5
 */

namespace App\Http\Controllers;


class IndexController extends Controller
{
    public function index()
    {
        return view("admin.index");
    }
}