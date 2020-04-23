<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = "users";
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
