<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Status;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 新增微博
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:100|min:3'
        ]);

        Auth::user()->statuses()->create([
            'content' => $request['content'],
        ]);

        return back();
    }

    // 删除微博
    public function destroy(Status $status)
    {
        // 做删除授权的检测，不通过会抛出 403 异常。
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博删除成功！');
        return back();
    }
}
