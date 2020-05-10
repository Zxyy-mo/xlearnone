<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = "users";
    //粉丝关注模型绑定多对多绑定;
    // public function followers()
    // {
    //     //此方法关联的关系表名称是user_user(默认的);
    //     //return $this->belongsToMany(User::class);
    //     //此方法关联的关系表名称是followers;
    //     // return $this->belongsToMany(User::class,'followers');
    //     return $this->belongsToMany(User::class,'followers','user
    //         _id','follower_id');
    // }
    //用户关注人列表
    public function followings()
    {
        return $this->belongsToMany(User::class,'follwers','follower_id','user_id');
    }
    //用来获取粉丝关系表
        public function followers()
    {
        return $this->belongsToMany(User::Class, 'followers', 'user_id', 'follower_id');
    }
    //关注用户
    public function follow($user_ids)
    {
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        $this->followers()->sync($user_ids,false);
    }
    //取关
    public function unfollow($user_ids)
    {
         if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        $this->followers()->detach($user_ids,false);
    }
    //判断登录用户是否关注第三方用户
    public function isFollowing($user_id)
    {
        return $this->followings()->contains($user_id);
    }
    //feed获取用户模型
    public function feed()
    {
        return $this->statuses()->orderBy('created_at','desc');
    }
    //指明一个用户拥有多条微博
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }
    /**
     * $size 是头像的尺寸
     *  return的是头像的链接
     */
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim( $this->attributes['email'])));
        return "http://www.gravatar.com/avatar/{$hash}?s={$size}";
    }
    //boot方法会在模型完成初始化后加载,所以我们监听creating功能
    public static function boot()
    {
        parent::boot();
        static::creating(function($user){
            $user->activation_token = str_random(30);
        });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
