<?php

namespace App\Notifications;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class VerifyEmailNotification extends Notification
{
    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;
    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return (new MailMessage)
            ->subject(Lang::get('email.Verify Email Address'))
            ->greeting(Lang::get('email.Welcome,'))
            ->line("Thank you for joining GenesisBricks {$this->user->full_name}")
            ->line(Lang::get('email.To activate your account and verify your email address, please click the following link:'))
            ->action(Lang::get('email.Verify Email Address'), $verificationUrl)
            ->line(Lang::get('email.Or paste this URL in your browser:') . " $verificationUrl")
            ->line(Lang::get('email.If you have received this email by mistake, it’s likely because someone entered your email address while trying to create an account on GenesisBricks. If you don’t click the verification link, the account will not be activated.'))
            ->line(Lang::get('email.Sincerely,'))
            ->line(Lang::get('email.Genesis Bricks'));
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
