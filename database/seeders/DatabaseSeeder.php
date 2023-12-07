<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\AreaSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            //UserSeeder::class,
            RoleSeeder::class,
            AreaSeeder::class,
            GrausSeeder::class,
            Permission05122023Seeder::class
        ]);
    }
}
