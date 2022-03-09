<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NotificationsHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getAllNotifications()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $user = User::findOrFail(auth()->user()->id);
            $notifications = $user->notifications;
            $arrayCollections = [];
            foreach ($notifications as $notification) {
                $arrayCollections[] = NotificationsHelper::getDetail($notification);
            }
            $data['data'] = $arrayCollections;
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function getNotifications($type)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $user = User::findOrFail(auth()->user()->id);
            $notifications = $user->notifications;
            $arrayCollections = [];
            foreach ($notifications as $notification) {
                if ($notification->data['type'] == $type) {
                    $arrayCollections[] = NotificationsHelper::getDetail($notification);
                }
            }
            $data['data'] = $arrayCollections;
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

//    public function getNotificationData(DatabaseNotification $notification)
//    {
//        $data = [];
//        switch ($notification->type) {
//            case "App\Notifications\VendorAssignQuoNotification";
//                $data['title'] = "You have been assign with a new product request.";
//                $data['link'] = "/vendor/product-request/edit/".$notification->data['quotation']->id;
//                $data['notification'] = $notification;
//                break;
//            case "App\Notifications\Quotation\SMQuotationStatusChangeNotification";
//                $data['title'] = "Quotation no. " . $notification->vendorQuotationProduct->vendorQuotation->quotation->reference_no . $notification->status == "Review" ? " is sent for Review." : " is " . $notification->status . ".";
//                $data['link'] = "/quotations/vendor/".$notification->data['vendorQuotationProduct']->vendorQuotation->id."/".$notification->data['vendorQuotationProduct']->id;
//                $data['notification'] = $notification;
//                break;
//            case "App\Notifications\Quotation\VendorQuotationStatusChangeNotification";
//                $data['title'] = "Quotation no. " . $notification->vendorQuotationProduct->vendorQuotation->quotation->reference_no . $notification->status == "Review" ? " is sent for Review." : " is " . $notification->status . ".";
//                $data['link'] = "/vendor/product-request/edit/".$notification->data['vendorQuotationProduct']->vendorQuotation->id."/".$notification->data['vendorQuotationProduct']->id;
//                $data['notification'] = $notification;
//                break;
//            default:
//                break;
//        }
//        return $data;
//    }
//
    public function unreadCount($type = null)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            if ($type != 'All') {
                $unreadNotifications = Auth::user()->unreadNotifications;
                $count = 0;
                foreach ($unreadNotifications as $unreadNotification) {
                    if ($unreadNotification->data['type'] == $type) {
                        $count = $count + 1;
                    }
                }
                $data['data'] = $count;
            } else {
                $data['data'] = Auth::user()->unreadNotifications->count();
            }
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }
}
