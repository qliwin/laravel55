<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * [update description]
     * @param  User   $currentUser [当前登录用户]
     * @param  User   $user        [需授权的用户]
     * @return [type]              [description]
     */
    public function update(User $currentUser, User $user)
    {
        return  $currentUser->id === $user->id;
    }
}
