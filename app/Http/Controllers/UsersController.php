<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        //中间件，除了except名单内的，都需要用户登录（黑名单），only白名单
        $this->middleware('auth', [
            'except'=>['show','create','store','index']
        ]);

        // $this->middleware('guest', [
        //     'only' => ['create']
        // ]);
    }
    
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
        //自动获取id=1的$user模型
        //利用了 Laravel 的『隐性路由模型绑定』功能，直接读取对应 ID 的用户实例 $user，未找到则报错；
        //将查找到的用户实例 $user 与编辑视图进行绑定；
        return view('users.show', compact('user'));
    }
    
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    
    /**
     * 更新用户资料
     * @param  User    $user    [description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:50',
            'password'=>'nullable|confirmed|min:1'
        ]);
        
        //$user->update([
        //    'name'=>$request->name,
        //    'password'=>bcrypt($request->password)
        //]);
        
        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;
        //密码不为空时，更新
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);
        
        session()->flash('success', '资料更新成功');
        return redirect()->route('users.show', [$user]);
    }

    //用户列表
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
}
