<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TestsController extends Controller
{
    public function test()
    {
        $arr = [1,2,3];
        p($arr);
    }
}
