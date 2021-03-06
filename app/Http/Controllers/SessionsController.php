<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

	//显示登录页面
    public function create()
    {
    	return view('sessions.create');
    }    

    //创建新会话（登录）
	public function store(Request $request)
    {
    	//array(2) { ["email"]=> string(12) "test1@qq.com" ["password"]=> string(1) "1" }
    	$credentials = $this->validate($request, [
			'email'    =>'required|email|max:255',
			'password' =>'required'
    	]);

    	if (Auth::attempt($credentials, $request->has('remember'))) {
            // 登录成功后的相关操作
            // session()->flash('success', '欢迎回来！');
            // return redirect()->route('users.show', [Auth::user()]);
            // return redirect()->intended(route('users.show', [Auth::user()]));
            if (Auth::user()->activated) {
               session()->flash('success', '欢迎回来！');
               return redirect()->intended(route('users.show', [Auth::user()]));
            } else {
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }
       } else {
           // 登录失败后的相关操作
           session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
           // return redirect()->back();
           return back()->withInput();
       }

    	return;
    }    

    //销毁会话（退出登录
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
