<?php

namespace App\Listeners;

use App\Notifications\VendorAssignQuoNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class VendorAssignQuoListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        $vendorQuotation = $event->vendorQuotation;
        Notification::send($user, new VendorAssignQuoNotification($user, $vendorQuotation));
    }
}
