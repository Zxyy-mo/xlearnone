<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest',[
            'only'=>'create'
        ]);
    }
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
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password],$request->has('remember'))){
            session()->flash('success','欢迎回来!');
            $fallback = route('users.show',[Auth::user()]);
            return redirect()->intended($fallback);
        }else{
            session()->flash('danger','很抱歉，您的邮箱和密码不匹配!');
            //withInput可以保存用户的错误输入
            return redirect()->back()->withInput();
        }
    }
    //退出登陆
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect()->route('login');
    }
}
