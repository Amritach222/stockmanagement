<?php

namespace App\Notifications\PO;

use App\Models\PurchaseOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use function url;

class POStatusChangeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($status, PurchaseOrder $purchaseOrder)
    {
        $this->status = $status;
        $this->purchaseOrder = $purchaseOrder;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('PO Status Change')
            ->greeting('Hello ' . $this->purchaseOrder->user->name)
            ->line('Purchase Order no. ' . $this->purchaseOrder->reference . ' has been ' . $this->status . ' from vendor ' . $this->purchaseOrder->vendor->name . '.')
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
            'type' => 'PO',
            'status' => $this->status,
            'purchaseOrder' => $this->purchaseOrder
        ];
    }
}
