<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AgentNotification extends Notification
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

        if($this->data['type'] == 'deliveryAssigned'){
            $array=[
                'title' => $this->data['title'],
                'order' => $this->data['order_no'],
                'message'=>$this->data['message'] ?? 'Canably has assigned a order('.$this->data['order_no'].') delivery to you',
            ];
        }elseif($this->data['type'] == 'payoutGiven'){
            $array=[
                'title' => $this->data['title'],
                'amount' => '$'.$this->data['amount'],
                'message'=>$this->data['message'] ?? 'Canably paid you $'.$this->data['amount'],
            ];
        }
        return $array;
    }
}
