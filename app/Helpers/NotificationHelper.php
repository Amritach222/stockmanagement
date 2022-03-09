<?php


namespace App\Helpers;


use App\Coupon;
use App\Product;
use App\Setting;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationsHelper
{
    /**
     * @param DatabaseNotification $notification
     * @return array
     */
    static function getDetail(DatabaseNotification $notification)
    {
        $data = [];
        switch ($notification->type) {
            case "App\Notifications\VendorAssignQuoNotification";
                $data['title'] = "You have been assign with a new product request.";
                $data['link'] = "/vendor/product-request/edit/".$notification->data['quotation']->id;
                $data['notification'] = $notification;
                break;
            case "App\Notifications\Quotation\SMQuotationStatusChangeNotification";
                $data['title'] = "Quotation no. " . $notification->vendorQuotationProduct->vendorQuotation->quotation->reference_no . $notification->status == "Review" ? " is sent for Review." : " is " . $notification->status . ".";
                $data['link'] = "/quotations/vendor/".$notification->data['vendorQuotationProduct']->vendorQuotation->id."/".$notification->data['vendorQuotationProduct']->id;
                $data['notification'] = $notification;
                break;
            case "App\Notifications\Quotation\VendorQuotationStatusChangeNotification";
                $data['title'] = "Quotation no. " . $notification->vendorQuotationProduct->vendorQuotation->quotation->reference_no . $notification->status == "Review" ? " is sent for Review." : " is " . $notification->status . ".";
                $data['link'] = "/vendor/product-request/edit/".$notification->data['vendorQuotationProduct']->vendorQuotation->id."/".$notification->data['vendorQuotationProduct']->id;
                $data['notification'] = $notification;
                break;
            default:
                break;
        }
        return $data;
    }

    static function unreadCount()
    {
        return Auth::user()->unreadNotifications->count();
    }

}
