<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new Setting([
            'title'=>'RKD Holdings',
            'currency'=>'NRP',
            'time_zone'=>'GMT +5:45',
        ]);
        $setting->save();
    }
}
