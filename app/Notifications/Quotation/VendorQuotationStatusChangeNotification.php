<?php

namespace App\Notifications\Quotation;

use App\Models\VendorQuotationProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use function url;

class VendorQuotationStatusChangeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($type, $status, VendorQuotationProduct $vendorQuotationProduct)
    {
        $this->type = $type;
        $this->status = $status;
        $this->vendorQuotationProduct = $vendorQuotationProduct;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Quotation no. ' . $this->vendorQuotationProduct->vendorQuotation->quotation->reference_no . $this->status == 'Review' ? ' is sent for Review.' : ' is ' . $this->status . '.')
//                    ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => $this->type,
            'status' => $this->status,
            'vendorQuotationProduct' => $this->vendorQuotationProduct
        ];
    }
}
