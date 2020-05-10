<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Status;

class StatusesController extends Controller
{
   public function __construct()
   {
   		$this->middleware('auth');
   }
    //
    public function store(Request $request)
    {
    	//validate验证器 验证$request传输过来的内容中的content键
    	$this->validate($request,[
    		'content'=> 'required|max:140',
    	]);
    	//因为模型关联 我们用$user->statuses()->create()此方法创建可以将微博内容与用户模型关联
    	//因为在此我们利用了auth权限 所以我们可以写成
    	//auth::user()->statuses()->create;
    	Auth::user()->statuses()->create([
    		'content'=>$request['content']
    	]);
    	session()->flash('success','微博发布成功');
    	//返回路由
    	return redirect()->back();
    }
    public function destroy(Status $status)
    {
        $this->authorize('destroy',$status);
        $status->delete();
        session()->flash('success','删除信息成功');
        return redirect()->back();
    }
}

