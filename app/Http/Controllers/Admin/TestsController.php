<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TestsController extends Controller
{
    public function test()
    {
        echo getenv('APP_ENV');
    }
}
