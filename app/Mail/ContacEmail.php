<?php

namespace App\Mail;

use App\Models\BookingHotel_Model;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContacEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public BookingHotel_Model $model;
    public string $NameRecive;
    public string $typeRoomName;
    public string $hotelName;
    public string $mailRecive;
    public $totalDay;

    public function __construct(
        BookingHotel_Model $model,
        string $NameRecive,
        string $typeRoomName,
        string $hotelName,
        string $mailRecive
    ) {
        $this->model = $model;
        $this->NameRecive = $NameRecive;
        $this->typeRoomName =  $typeRoomName;
        $this->hotelName =  $hotelName;
        $this->mailRecive = $mailRecive;

        $timeRecive = new DateTime($model['TimeRecive']);
        $timeLeave = new DateTime($model['TimeLeave']);
        $this->totalDay = $timeRecive->diff($timeLeave);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thông báo từ hệ thống đặt phòng online - Finder',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.view-contact-mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
