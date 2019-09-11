<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            [
                'name' => 'Kamran',
                'email' => 'kamran@gmail.com',
                'password' => bcrypt('111111'),
                'user_role_id' => 1,
                'status' => 'Enabled',
                'created_at' => date('Y-m-d H:i:s'),
                'shop_id' => Null,
            ],
            [
                'name' => 'Admin',
                'email' => 'a@g.c',
                'password' => bcrypt('123456'),
                'user_role_id' => 2,
                'status' => 'Enabled',
                'created_at' => date('Y-m-d H:i:s'),
                'shop_id' => Null,
            ],
            [
                'name' => 'Guest',
                'email' => 'g@g.c',
                'password' => bcrypt('123456'),
                'user_role_id' => 3,
                'status' => 'Enabled',
                'created_at' => date('Y-m-d H:i:s'),
                'shop_id' => Null,
            ],
        ]);
    }
}
