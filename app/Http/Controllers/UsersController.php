<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller
{
    /**
     * 注册页
     */
    public function create()
    {
        return view('users.create');
    }
    
    /**
     * 存储注册信息
     */
    public function store(Request $request)
    {
        //验证
        $this->validate($request, [
            'name'     => 'required|max:50',
            'email'    => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:1'
        ]);

        //逻辑
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),//加密
        ]);
        //注册完后自动登录
        Auth::login($user);
        //渲染
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        //$user模型会自动获取主键id，所以等同于 redirect()->route('users.show', [$user->id]);
        return redirect()->route('users.show', [$user]);
    }
    
    /**
     * 展示个人信息
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        dd(get_db_config());
        //自动获取id=1的$user模型
        return view('users.show', compact('user'));
    }
}
