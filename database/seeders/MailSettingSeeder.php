<?php

namespace Database\Seeders;

use App\Models\MailSetting;
use Illuminate\Database\Seeder;

class MailSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new MailSetting([
            'mail_address' => 'info@rkdholdings.com',
            'mail_from_name' => 'RKD Holdings'
        ]);
        $setting->save();
    }
}
