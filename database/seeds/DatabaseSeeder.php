<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //unguard 负责解除自动填充操作限制
         Model::unguard();
       $this->call(UsersTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        //reguard 负责恢复限制
         Model::reguard();
    }
}
