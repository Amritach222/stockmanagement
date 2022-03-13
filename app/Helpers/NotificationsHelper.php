<?php


namespace App\Helpers;

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
                $data['link'] = "/vendor/product-request/edit/" . $notification->data['quotation']->id;
                $data['notification'] = $notification;
                break;
            case "App\Notifications\Quotation\SMQuotationStatusChangeNotification";
                $first = "Quotation no. " . $notification->data['vendorQuotationProduct']['vendor_quotation']['quotation']['reference_no'] ."for product " . $notification->data['vendorQuotationProduct']['quotation_product']['product']['name'];
                $second = $notification->data['status'] == "Review" ? " is sent for Review." : " is " . $notification->data['status'] . ".";
                $data['title'] = $first . $second;
                $data['link'] = "/quotations/vendor/" . $notification->data['vendorQuotationProduct']['vendor_quotation']['id'] . "/" . $notification->data['vendorQuotationProduct']['id'];
                $data['notification'] = $notification;
                break;
            case "App\Notifications\Quotation\VendorQuotationStatusChangeNotification";
                $first = "Quotation no. " . $notification->data['vendorQuotationProduct']['vendor_quotation']['quotation']['reference_no'] ."for product " . $notification->data['vendorQuotationProduct']['quotation_product']['product']['name'];
                $second = $notification->data['status'] == "Review" ? " is sent for Review." : " is " . $notification->data['status'] . ".";
                $data['title'] = $first . $second;
                $data['link'] = "/vendor/product-request/edit/" . $notification->data['vendorQuotationProduct']['vendor_quotation']['id'] . "/" . $notification->data['vendorQuotationProduct']['id'];
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
