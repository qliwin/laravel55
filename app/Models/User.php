<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    //白名单，除了这些其余提交的字段都不受理
    protected $fillable = [
        'name', 'email', 'password',
    ];

    //对用户密码或其它敏感信息在用户实例通过数组或 JSON 显示时进行隐藏
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function gravatar($size = 100)
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        echo $hash;
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
}
