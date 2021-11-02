<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();

        $this->call(PermissionSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(MailSettingSeeder::class);
        $this->call(SmsSettingSeeder::class);
        $this->call(MailTemplateSeeder::class);
        $this->call(ModelSeeder::class);
    }
}
