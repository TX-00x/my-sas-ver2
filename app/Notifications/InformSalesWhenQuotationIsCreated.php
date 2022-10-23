<?php

namespace App\Notifications;

use App\Models\Quotation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InformSalesWhenQuotationIsCreated extends Notification
{
    use Queueable;

    private Quotation $quotation;

    public function __construct(Quotation $quotation)
    {
        $this->quotation = $quotation;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Quotation ' . $this->quotation->number . ' waiting for your approval')
                    ->greeting('Dear '. $notifiable->name)
                    ->line('Quotation #' . $this->quotation->number . ' requires your approval in order to send to the customer')
                    ->action('View Quotation', url(route('quotations.show', $this->quotation)))
                    ->line('Thank you!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
