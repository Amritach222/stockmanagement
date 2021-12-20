<?php

namespace App\Providers;

use App\Models\MailSetting;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if(DB::getSchemaBuilder()->hasTable('mail_settings')) {
            $mail = DB::table('mail_settings')->first();
            if ($mail) //checking if table is not empty
            {
                $config = array(
                 'driver' => $mail->mail_mailer,
                    'host' => $mail->mail_host,
                    'port' => $mail->mail_port,
                    'from' => array('address' => $mail->mail_address, 'name' => $mail->mail_from_name),
                    'encryption' => $mail->encryption,
                 'username' => $mail->username,
                    'password' => $mail->password,
                );
                Config::set('mail', $config);
            }
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
