<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class FollowersController extends Controller
{
    public function __construct()
    {
        //加载auth中间件来判断操作用户是否已经登入
        $this->middleware('auth');
    }

    //
    public function store(User $user)
    {
        $this->authorize('follow',$user);
        if(!Auth::user()->isFollowing($user->id)) {
            Auth::user()->follow($user->id);
        }
        return redirect()->route('users.show', $user->id);
    }
    public function destroy(User $user)
    {
        $this->authorize('follow',$user);
        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);
        }
        return redirect()->route('users.show', $user->id);
    }
}
