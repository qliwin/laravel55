<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use Auth;
use App\Models\Status;

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

    public static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $user->activation_token = str_random(30);
        });

    }

    // 头像
    public function gravatar($size = 100)
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));

        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    // 微博 
    public function statuses()
    {
        return $this->hasMany(Status::class, 'user_id', 'id');
    }

    // 微博、排序的
    public function feed()
    {
        $user_ids = Auth::user()->followings->pluck('id')->toArray();
        array_push($user_ids, Auth::user()->id);
        // dump($user_ids);
        return Status::whereIn('user_id', $user_ids)
                        ->with('user')
                        ->orderBy('created_at', 'desc');
    }

    // 粉丝
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    // 关注列表
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    // 判断是否在关注人列表中
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }

    // 关注
    public function follow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);
    }

    // 取消关注
    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }
}
