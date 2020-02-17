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
        // $this->call(UsersTableSeeder::class);
        $this->call(FatcomDataRowsTableSeeder::class);
        $this->call(FatcomDataTypesTableSeeder::class);
        $this->call(FatcomMenuItemsTableSeeder::class);
        $this->call(FatcomPermissionsTableSeeder::class);
        $this->call(FatcomPermissionRoleTableSeeder::class);
        $this->call(FatcomRolesTableSeeder::class);
        $this->call(FatcomSettingsTableSeeder::class);
    }
}
