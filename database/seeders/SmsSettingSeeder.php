<?php

namespace Database\Seeders;

use App\Models\SmsSetting;
use Illuminate\Database\Seeder;

class SmsSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new SmsSetting();
        $setting->save();
    }
}
