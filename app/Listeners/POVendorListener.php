<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\PO\POStatusChangeNotification;
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
        $status = $event->status;

        $purchaseOrder = $event->purchaseOrder;
        if (($status == 'Create')) {
            $vendor = $purchaseOrder->vendor;
            $user = User::findOrFail($vendor->user_id);
            Notification::send($user, new POVendorNotification($status, $purchaseOrder));
        }else{
            $user = User::findOrFail($purchaseOrder->user_id);
            Notification::send($user, new POStatusChangeNotification($status, $purchaseOrder));
        }
    }
}
