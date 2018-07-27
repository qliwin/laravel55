<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //创建50个用户
        $users = factory(User::class)->times(50)->make();
        //批量插入
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());
        //更新第一个用户信息
        $user = User::find(1);
        $user->name = 'qli';
        $user->email = 'qli@qq.com';
        $user->password = bcrypt('1');
        $user->save();
    }
}
