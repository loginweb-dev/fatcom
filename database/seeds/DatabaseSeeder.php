<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FatcomDatabaseSeeder::class);
        $this->call(FatcomPermissionsTableSeeder::class);
        $this->call(FatcomPermissionRoleTableSeeder::class);
        $this->call(CustomizedMarcasTableSeeder::class);
        $this->call(CustomizedDataRowsTableSeeder::class);
    }
}
