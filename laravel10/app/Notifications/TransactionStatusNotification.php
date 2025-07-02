<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionStatusNotification extends Notification
{
    use Queueable;

    protected $transaction;

    /**
     * Crée une nouvelle instance de notification.
     *
     * @param \App\Models\EvenementPortefeuille $transaction
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Obtenez les canaux de diffusion de la notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
{
    return ['database', 'mail']; // Utilisez 'mail' pour envoyer un e-mail
}

    /**
     * Obtenez la représentation sous forme de tableau de la notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->transaction->statut === 'valide'
                ? "Votre transaction de {$this->transaction->montant} a été validée."
                : "Votre transaction de {$this->transaction->montant} a été rejetée.",
            'transaction_id' => $this->transaction->id,
            'type' => 'transaction_status',
        ];
    }
    public function toMail($notifiable)
{
    return (new MailMessage)
        ->line('Statut de votre transaction')
        ->line($this->transaction->statut === 'valide'
            ? "Votre transaction de {$this->transaction->montant} a été validée."
            : "Votre transaction de {$this->transaction->montant} a été rejetée.")
        ->action('Voir les détails', url('/notifications'))
        ->line('Merci d\'utiliser notre application!');
}
}