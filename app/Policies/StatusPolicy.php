<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Status;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    //判断是否用户ID与微博所属ID相对应
    public function destroy(User $user, Status $status)
    {
        return $user->id === $status->user_id;
    }
    public function __construct()
    {
        //
    }
}
