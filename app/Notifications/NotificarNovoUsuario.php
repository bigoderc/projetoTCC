<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificarNovoUsuario extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $senha_temporaria;

    public function __construct($senha_temporaria)
    {
        $this->senha_temporaria = $senha_temporaria;
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
        return (new MailMessage)
            ->subject('Bem-vindo!')
            ->greeting('Olá')
            ->line('Olá ' . $notifiable->name . ', você foi cadastrado com sucesso!')
            ->line('Sua senha temporária é: ' . $this->senha_temporaria)
            ->line('Assim que possível, faça a alteração da senha temporária acessando meu perfil e alterando a senha.')
            ->action('Acessar o site', url('/'))
            ->line('Obrigado por se juntar a nós!')
            ->salutation('Guilherme Ramos Correia');
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
