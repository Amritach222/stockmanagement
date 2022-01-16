<?php

namespace App\Notifications;

use App\Models\Setting;
use App\Models\User;
use App\Models\VendorQuotation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorAssignQuoNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, VendorQuotation $vendorQuotation)
    {
        $this->user = $user;
        $this->vendorQuotation = $vendorQuotation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject('You have a new product request.')
            ->greeting('Hello ' . $this->user->name)
            ->line('You have been assign with a new product request. Please click the link below to check the request list. Thank You.')
            ->action('Click here', url('/quotations/edit/' . $this->vendorQuotation->quotation_id))
            ->line('Thank you for choosing ' . Setting::companyName() . "!");
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
            //
        ];
    }
}
