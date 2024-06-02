<?php

namespace App\Services\SendMail;

use App\Models\BookingHotel_Model;

interface ISendMailService
{
    public function sendMailNotifyToBuyer(
        BookingHotel_Model $model,
        string $NameRecive,
        string $typeRoomName,
        string $hotelName,
        string $mailRecive
    );
}
