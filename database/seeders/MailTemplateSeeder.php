<?php

namespace Database\Seeders;

use App\Models\MailTemplate;
use Illuminate\Database\Seeder;

class MailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = new MailTemplate([
            'title' => 'Change your password',
            'content' => 'Please click the button below to reset your password.',
            'view_page' => 'mail.reset_password',
        ]);
        $template->save();

        $template = new MailTemplate([
            'title' => 'Password Changed',
            'content' => 'Your password has been changed successfully.',
            'view_page'=>'mail.password_change',
        ]);
        $template->save();

        $template = new MailTemplate([
            'title' => 'Notice',
            'content' => 'New notice arrived.',
            'view_page'=>'mail.notice',
        ]);
        $template->save();

        $template = new MailTemplate([
            'title' => 'Welcome to RKD',
            'content' => 'You are heartily welcome to RKD Holdings.',
            'view_page'=>'mail.welcome',
        ]);
        $template->save();
    }
}
