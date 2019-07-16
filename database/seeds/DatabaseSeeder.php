<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserRolesSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(AppSettingsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(UsersWidgetSeeder::class);
        $this->call(ShopsMenuSeeder::class);
        $this->call(CustomersSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(OrdersSeeder::class);

    }

    public function call($class)
    {
        // check if the seeder already run
        $seeder = DB::table('seeders')->where('class', $class)->first();
        if ($seeder) {
            $this->command->warn("Already seeded {$class}");
            return;
        }

        // run the seeder
        parent::call($class);

        // add the seeder to seeded list
        DB::table('seeders')->insert([
            'class' => $class,
            'ran_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
