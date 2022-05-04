<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\Quotation\SMQuotationStatusChangeNotification;
use App\Notifications\Quotation\VendorQuotationStatusChangeNotification;
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
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $type = $event->type;
        $status = $event->status;
        $vendorQuotationProduct = $event->vendorQuotationProduct;
        if ((($status == 'Approved') or ($status == 'Cancelled')) or ($status == 'Review')) {
            $vendor = $vendorQuotationProduct->vendorQuotation->vendor;
            $user = User::findOrFail($vendor->user_id);
            Notification::send($user, new VendorQuotationStatusChangeNotification($type, $status, $vendorQuotationProduct));
        } else {
            $quotation = $vendorQuotationProduct->vendorQuotation->quotation;
            $user = User::findOrFail($quotation->user_id);
            Notification::send($user, new SMQuotationStatusChangeNotification($type, $status, $vendorQuotationProduct));
        }
    }
}
