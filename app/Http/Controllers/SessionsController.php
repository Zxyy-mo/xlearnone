<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SessionsController extends Controller
{
    //创建登陆界面
    public function create()
    {
        return view('sessions.create');
    }
    //保存登陆信息
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            session()->flash('success','欢迎回来!');
            return redirect()->route('users.show',[Auth::user()]);
        }else{
            session()->flash('danger','很抱歉，您的邮箱和密码不匹配!');
            return redirect()->back()->withInput();
        }
    }
    //退出登陆
    public function destroy()
    {

    }
}
