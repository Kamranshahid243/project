<?php

use Illuminate\Database\Seeder;

class UsersWidgetSeeder extends Seeder
{
    public function run()
    {
        $id = DB::table('widgets')->insertGetId([
            'title' => 'Online Users',
            'color' => 'warning',
            'template_url' => 'users-widget-template.html',
            'enabled' => 1,
            'locked' => 0,
            'size_x' => 7,
            'size_y' => 7,
            'min_size_x' => null,
            'min_size_y' => null,
            'row' => 0,
            'col' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('user_role_widgets')->insert([
            ['user_role_id' => '1', 'widget_id' => $id],
        ]);
    }
}
