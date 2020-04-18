<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
class UsersController extends Controller
{
    //
    public function create()
    {
        return view('users.create');
    }
    public function show(User $user)
    {
        return View('users.show',compact('user'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        //用户注册后自动登录
        Auth::login($user);
        //flash只在下一次使用时生效
        session()->flash('success','欢迎,您将在这里入坑laravel');
        //redirect重定向
        return redirect()->route('users.show',[$user->id]);
    }
}
