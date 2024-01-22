<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\TextMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SafetyNotification extends Notification
{
    use Queueable;

    public $user;
    public $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $data)
    {
        $this->user = $user;
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
        $sendNotification   = [];
        $userNotificationSettings = [];
        $sendEmail          = false;
        $sendText           = false;
        $sendDBPush         = false;

        if($this->user->profile){
            $userNotificationSettings       = $this->user->profile->notifications;
        }

        //User (profile) notification settings
        $userEmailNotificationSettings  = isset($userNotificationSettings['medium']['email']) ? $userNotificationSettings['medium']['email'] : false;
        $userDbNotificationSettings     = isset($userNotificationSettings['medium']['inApp']) ? $userNotificationSettings['medium']['inApp'] : false;

        // (site) notification settings
        $siteEmailNotificationSettings  = getSiteSetting('site_email');
        //$siteDbNotificationSettings     = config('services.notifications')['inApp'];


        //For admin
        if(
            $this->data['type'] == 'womenSafetyRequest'
        ){
            array_push($sendNotification, 'database');
        }

        //mandatory email notification
        // if($siteEmailNotificationSettings &&
        //     ($this->data['type'] == 'newDriverRegistration' ||
        //     $this->data['type'] == 'registrationCompleteByAgency' ||
        //     $this->data['type'] == 'emailVerify' ||
        //     $this->data['type'] == 'emailVerification' ||
        //     $this->data['type'] == 'emailVerifyResend' ||
        //     $this->data['type'] == 'emailVerified' ||
        //     $this->data['type'] == 'resetPassword' ||
        //     $this->data['type'] == 'passwordChanged' ||
        //     $this->data['type'] == 'emailChanged' ||
        //     $this->data['type'] == 'accountApproved' ||
        //     $this->data['type'] == 'accountUnapproved' ||
        //     $this->data['type'] == 'accountBan' ||
        //     $this->data['type'] == 'accountActive' ||
        //     $this->data['type'] == 'userMembershipPurchase' ||
        //     $this->data['type'] == 'postConsentSendToModel')
        // ){
        //     if($this->user->email){
        //         array_push($sendNotification, 'mail');
        //     }
        // }

        if($userEmailNotificationSettings && $siteEmailNotificationSettings)
        {
            if($this->data['type'] == 'newReview'){
                $sendEmail = true;
            }

            if($sendEmail){
                array_push($sendNotification, 'mail');
            }
        }
        return $sendNotification;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the text representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return boolean
     */
    public function toTextMessage($notifiable)
    {
        return (new TextMessage)
        ->content($this->data['from_user_name'] . ' send you a new ' . $this->data['message_type'] . ' message. Go to your message section to see the message. -Canably');
    }

    /**
     * Get the text representation of the db notification.
     *
     * @param  mixed  $notifiable
     * @return data
     */
    /**
     * Get the text representation of the db notification.
     *
     * @param  mixed  $notifiable
     * @return data
     */
    public function toDatabase($notifiable)
    {
        $mailData['subject'] = '';
        $mailData['line']    = '';
        $mailData['data']    = '';


        if($this->data['type'] == 'womenSafetyRequest'
        ){//queue  //for admin
            $mailData['subject']        = $this->data['title'];
            $mailData['line']           = $this->data['message'];
            $mailData['data']           = $this->data;
        }


        return [
            'title'     => $mailData['subject'],
            'message'   => $mailData['line'],
            'data'      => $mailData['data']
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
