<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\PO\POVendorNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class POVendorListener
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $type = $event->type;

        $purchaseOrder = $event->purchaseOrder;
        if (($type == 'Create')) {
            $vendor = $purchaseOrder->vendor;
            $user = User::findOrFail($vendor->user_id);
            Notification::send($user, new POVendorNotification($type, $purchaseOrder));
        }
    }
}
