<?php

namespace App\Notifications;

use App\Models\TeacherDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentVerificationNotification extends Notification
{
    use Queueable;

    public function __construct(
        public TeacherDocument $document,
        public string $status,
        public ?string $notes = null
    ) {
    }

    /**
     * Channel notifikasi.
     *
     * mail = email
     * database = notifikasi di aplikasi
     */
    public function via(object $notifiable): array
    {
        return [
            'mail',
            'database',
        ];
    }

    /**
     * Email.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $isVerified = $this->status === 'verified';

        $subject = $isVerified
            ? 'Dokumen Anda telah diterima'
            : 'Dokumen Anda ditolak';

        $message = $isVerified
            ? 'Dokumen yang Anda upload telah diperiksa dan dinyatakan diterima oleh pengawas.'
            : 'Dokumen yang Anda upload telah diperiksa dan dinyatakan ditolak oleh pengawas.';

        $mail = (new MailMessage)
            ->subject($subject)
            ->greeting('Halo ' . ($notifiable->name ?? 'Guru') . ',')
            ->line($message)
            ->line('Dokumen: ' . $this->document->title);

        if (!$isVerified && $this->notes) {
            $mail->line('Alasan penolakan: ' . $this->notes);
        }

        return $mail
            ->action(
                'Lihat Dokumen',
                route('guru.documents.index')
            )
            ->line('Silakan login ke aplikasi SIMOGU untuk melihat detail dokumen Anda.');
    }

    /**
     * Data notifikasi untuk database/aplikasi.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'document_verification',
            'document_id' => $this->document->id,
            'title' => $this->document->title,
            'status' => $this->status,
            'notes' => $this->notes,
            'message' => $this->status === 'verified'
                ? 'Dokumen Anda telah diterima oleh pengawas.'
                : 'Dokumen Anda ditolak oleh pengawas.',
        ];
    }
}