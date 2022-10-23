<?php

namespace App\Notifications;

use App\Models\Customer;
use App\Models\Quotation;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class InformCustomerWhenQuotationIsReady extends Notification
{
    use Queueable;

    private Quotation $quotation;
    private Customer $customer;

    public function __construct(Quotation $quotation, Customer $customer)
    {
        $this->quotation = $quotation;
        $this->customer = $customer;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $link = URL::signedRoute(
            'public.customer.quotation',
            ['quotation' => $this->quotation->number, 'email' => $this->customer->email]
        );

        return (new MailMessage)
                    ->greeting('Dear '. $this->customer->name)
                    ->subject('Quotation #' . $this->quotation->number .' from SAS Sports')
                    ->line('Please click on the following link in order to see the quotation.')
                    ->line('Also note that your approval is required in order to proceed with the quotation')
                    ->action('See Quotation', $link)
                    ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
