<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\SuratMasuk;
use App\Models\User;

class SuratStatusUpdated extends Notification
{
    use Queueable;

    protected $surat;
    protected $updatedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(SuratMasuk $surat, User $updatedBy)
    {
        $this->surat = $surat;
        $this->updatedBy = $updatedBy;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Status Surat Diperbarui')
            ->greeting('Halo,')
            ->line('Status surat dengan nomor: ' . $this->surat->nomor . ' telah diperbarui.')
            ->line('Status sekarang: ' . ucfirst($this->surat->status))
            ->line('Diperbarui oleh: ' . $this->updatedBy->name)
            ->action('Lihat Surat', url('/surat/' . $this->surat->id))
            ->line('Terima kasih telah menggunakan sistem.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'nomor' => $this->surat->nomor,
            'status' => $this->surat->status,
            'updated_by' => $this->updatedBy->name,
        ];
    }
}
