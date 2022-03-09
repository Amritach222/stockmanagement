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
            'mail_from_name' => 'RKD Holdings',
            'mail_mailer' => 'smtp',
            'mail_host' => 'smtp.mailtrap.io',
            'mail_port' => '2525',
            'username' => '56c40391832ded',
            'password' => '4ec7843d24bbb',
            'encryption' => 'tls',
        ]);
        $setting->save();
    }
}
