<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //time创建了50个数量的测试用用户 make将模型创建一个集合
        $users = factory(User::class)->times(50)->make();
        //然后使用模型添加数据 makeVisable是使字段暂时可见
        User::insert($users->makeVisible(['password','remember_token'])->toArray());

        //接下来重新定义ID为1的是我们可以登陆的用户
        $user = User::find(1);
        $user->name = 'xiaoyu';
        $user->email = '1016673080@qq.com';
        $user->password = bcrypt('xiaoyu');
        $user->save();
    }
}
