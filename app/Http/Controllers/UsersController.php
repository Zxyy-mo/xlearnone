<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;

class UsersController extends Controller
{
    //类似于tp的中间件 only是执行的方法，except是除了这些方法
    public function  __construct()
    {
        //利用auth来判断是否处于登陆状态
        $this->middleware('auth',[
            'except'=>['show','create','store','index', 'confirmEmail']
        ]);
        $this->middleware('guest',[
            'only'=>['create']
        ]);
    }
    //用户列表界面
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }
    //创建用户注册界面
    public function create()
    {
        return view('users.create');
    }
    public function show(User $user)
    {
        return View('users.show',compact('user'));
    }
    //接收用户注册信息并处理
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
        $this->sendEmailConfirmationTo($user);
        session()->flash('success','邮件已经发送至您的邮箱,请点击验证注册');
        return redirect('/');
        //用户注册后自动登录
        //Auth::login($user);
        //flash只在下一次使用时生效
        //session()->flash('success','欢迎,您将在这里入坑laravel');
        //redirect重定向
        //return redirect()->route('users.show',[$user->id]);
    }
    //创建更改用户资料界面
    public function edit(User $user)
    {
        //authorize是来自controller的，update是policy中的Userpolicy中的update验证,第二个参数对应的是第二个值默认第一个值框架自带
        $this->authorize('update',$user);
        //上方代码是判断用户是否有权限更改
        return view('users.edit',compact('user'));
    }
    //提交用户信息更改
    public function update(User $user,Request $request)
    {
        $this->authorize('update',$user);
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6',
        ]);
        $data=[];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }
        $user::updated($data);
        session()->flash('success','更新用户资料成功');
        return redirect()->route('users.show',$user);
    }
    //用户删除
    public function destroy(User $user)
    {
        //需要先判断一下已登陆用户是否为管理员
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }
    //邮件发送
    protected function sendEmailConfirmationTo($user)
    {
        //send的参数是发送视图模板,$data是发送的数据,闭包
        $view='emails.confirm';
        $data = compact('user');
        $from='summer@example.com';
        $name='Xiaoyu';
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";
        Mail::send($view,$data,function ($message) use ($from,$name,$to,$subject){
            $message->from($from,$name)->to($to)->subject($subject);
        });
    }
    public function confirmEmail($token)
    {
        $user = User::where('activation_token',$token)->firstOrFail();
        $user->activated = true;
        $user->activation_token = null;
        $user->save();
        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }
}
