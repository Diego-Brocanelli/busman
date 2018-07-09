<?php

namespace Busman\People\Notifications\Customers;

use Busman\People\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Busman\Spark\Notifications\SparkChannel;
use Busman\Spark\Notifications\SparkNotification;

class CustomerCreated extends Notification
{
    use Queueable;

    public $customer;

    /**
     * Create a new notification instance.
     *
     * @param \Busman\People\Models\Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SparkChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            //
        ]);
    }

    public function toSpark($notifiable)
    {
        return (new SparkNotification)
            ->action('Detail', '/link/to/task')
            ->icon('fa-users')
            ->body('A new customer has been completed!');
    }
}
