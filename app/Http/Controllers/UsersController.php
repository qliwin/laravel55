<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
        
        //渲染
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        //等同于 redirect()->route('users.show', [$user->id]);
        return redirect()->route('users.show', [$user]);
    }
    
    /**
     * 展示个人信息
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        //自动获取id=1的$user模型
        return view('users.show', compact('user'));
    }
}
