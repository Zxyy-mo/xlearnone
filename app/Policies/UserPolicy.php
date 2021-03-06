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
     * update 验证更新
     *  输入currentUser目前登陆状态，user更改ID
     * @return true/false
     */
    public function update(User $currentUser,User $user)
    {
        return $currentUser->id === $user->id;
    }
    public function destroy(User $currentUser,User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
    //关注策略之自己不能关注自己
    public function follow(User $currentUser, User $user)
    {
        return $currentUser->id !== $user->Id;
    }
}
