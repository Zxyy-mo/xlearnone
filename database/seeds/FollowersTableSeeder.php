<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;
    	//获取去除ID为1的所用用户
        $followers = $users->slice(1);
        $followers_ids = $followers->pluck('id')->toArray();
        //关注除了1号用户以外的所有用户
        $user->follow($followers_ids);
        //除了1号以外的用户都来关注一号
        foreach($followers as $follow){
            $follow->follow($user_id);
        }
    }
}
