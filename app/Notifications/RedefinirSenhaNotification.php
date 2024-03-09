<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class RedefinirSenhaNotification extends Notification
{
    use Queueable;

    public $token;
    public $email;
    public $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $email, $name)
    {
        $this->token = $token;
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = 'http://localhost:8000/password/reset/'.$this->token.'?email='.$this->email;
        $minutos = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');

        return (new MailMessage)
            ->subject(Lang::get('Atualização de senha'))
            ->line(Lang::get('Esqueceu a senha? sem problema, vamos resolver isso.'))
            ->greeting(Lang::get('Olá, '.$this->name))
            ->action(Lang::get('Clique aqui para modificar a senha'), $url)
            ->line(Lang::get('Essa mensagem expira em '.$minutos.' Minutos'))
            ->line(Lang::get('Se você não solicitou uma redefinição de senha, nenhuma ação adicional será necessária.'))
            ->salutation(Lang::get('Até breve!'));
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
