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
            ->subject('📄 Pembaruan Status Surat | LLDIKTI Wilayah II')
            ->greeting('Yth. Bapak/Ibu,')
            ->line('Dengan hormat,')
            ->line('Kami ingin menginformasikan bahwa status surat dengan nomor:')
            ->line('**' . $this->surat->nomor_surat . '**')
            ->line('telah mengalami pembaruan status menjadi:')
            ->line('**' . ucfirst($this->surat->status) . '**')
            ->line('Surat ini diperbarui oleh: **' . $this->updatedBy->name . '** ('
                . $this->updatedBy->role->name
                . ($this->updatedBy->timKerja ? ' - ' . $this->updatedBy->timKerja->nama_timKerja : '')
                . ').')
            ->line('')
            ->line('**Penjelasan Status Surat:**')
            ->line('- **Diproses** : Surat sedang dalam proses disposisi oleh pihak terkait.')
            ->line('- **Ditindaklanjuti** : Surat sedang dalam tahap tindak lanjut oleh unit yang bersangkutan.')
            ->line('- **Selesai** : Proses tindak lanjut terhadap surat telah selesai dilakukan.')
            ->line('')
            ->line('Demikian informasi ini kami sampaikan. Atas perhatian dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.')
            ->salutation('Hormat kami,')
            ->salutation('Tim LLDIKTI Wilayah II');

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
