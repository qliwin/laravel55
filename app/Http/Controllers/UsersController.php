<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        // 除了except内的方法，其余都要auth认证
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']
        ]);

        // 仅有游客可以访问注册页
        $this->middleware('guest', [
            'only' => ['create']
        ]);
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
        // dd(get_db_config());
        //自动获取id=1的$user模型
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:1',
        ]);

        // $user->update([
        //     'name' => request('name'),
        //     'password' => bcrypt(request('password')),
        // ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);


        session()->flash('success', '个人资料更新成功！');
        return redirect()->route('users.show', [$user]);
    }

    /**
     * 用户列表
     * @return [type] [description]
     */
    public function index()
    {
        $users = User::paginate(5);
        return view('users.index', compact('users'));
    }

    /**
     * 刪除用戶
     * @return [type] [description]
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功刪除用戶！');
        return back();
    }
}
