<?php

namespace App\Providers;

use App\Events\ActivityLogEvent;
use App\Events\PasswordResetEvent;
use App\Events\QuotationCreateEvent;
use App\Events\QuotationStatusChangeEvent;
use App\Events\VendorAssignQuoEvent;
use App\Listeners\ActivityLogListener;
use App\Listeners\PasswordResetListener;
use App\Listeners\QuotationCreateListener;
use App\Listeners\QuotationStatusChangeListener;
use App\Listeners\VendorAssignQuoListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ActivityLogEvent::class => [
            ActivityLogListener::class,
        ],
        PasswordResetEvent::class => [
            PasswordResetListener::class,
        ],
        VendorAssignQuoEvent::class => [
            VendorAssignQuoListener::class,
        ],
        QuotationStatusChangeEvent::class => [
            QuotationStatusChangeListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
