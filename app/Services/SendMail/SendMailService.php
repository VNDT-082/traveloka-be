<?php

namespace App\Services\SendMail;

use App\Mail\ContacEmail;
use App\Models\BookingHotel_Model;
use DateTime;
use Illuminate\Support\Facades\Mail;

class SendMailService implements ISendMailService
{
    public function __construct()
    {
    }
    public function sendMailNotifyToBuyer(
        BookingHotel_Model $model,
        string $NameRecive,
        string $typeRoomName,
        string $hotelName,
        string $mailRecive
    ) {
        $timeRecive = new DateTime($model['TimeRecive']);
        $timeLeave = new DateTime($model['TimeLeave']);
        $totalDay = $timeRecive->diff($timeLeave)->days;
        $result_sendMail = Mail::send(
            'view-contact-mail',
            compact(
                'model',
                'NameRecive',
                'typeRoomName',
                'hotelName',
                'mailRecive',
                'totalDay'
            ),
            function ($email) use ($mailRecive) {
                $email->subject('Thông báo từ hệ thống đặt phòng online - Finder');
                $email->to($mailRecive);
            }
        );
        //$result_sendMail = Mail::to($mailRecive)->send(new ContacEmail($model, $NameRecive, $typeRoomName, $hotelName, $mailRecive));
        return $result_sendMail;
    }
}
