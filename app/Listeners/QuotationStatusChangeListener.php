<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\VendorQuotationStatusChangeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class QuotationStatusChangeListener
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
        $vendorQuotationProduct = $event->vendorQuotationProduct;
        if($status == 'Approved' or $status=='Cancelled' or $status == 'Review'){
            $vendor = $vendorQuotationProduct->vendorQuotation->vendor;
            $user = User::findOrFail($vendor->user_id);
        }else{
            $quotation = $vendorQuotationProduct->vendorQuotation->quotation;
            $user = User::findOrFail($quotation->user_id);
        }
        Notification::send($user, new VendorQuotationStatusChangeNotification($status, $vendorQuotationProduct));
    }
}
