<?php

use Illuminate\Database\Seeder;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*DB::table('app_settings')->truncate();
        DB::table('app_settings')->insert([
            [
                'config' => 'No. of concurrent active admins',
                'value' => '15',
                'comments' => 'Maximum number of users that are allowed to be "active" in the admin panel at the same time.',
                'category' => 'General',
            ],
        ]);*/
    }
}
