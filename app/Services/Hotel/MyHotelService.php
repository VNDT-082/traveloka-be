<?php

namespace App\Services\Hotel;

use App\Models\Hotel_Model;
use Illuminate\Support\Facades\DB;

class MyHotelService
{

    public function getAllHotels()
    {
        $hotels = Hotel_Model::all();

        return $hotels;
    }
    public function getHotelsByProvince($provinceName)
    {
        $hotels = DB::select("SELECT 
            hotel.Name,
            hotel.Address,
            hotel.IsActive,
            hotel.id,
            imageshotel.FileName,
            MIN(typeroom.Price) AS min_price,
            COUNT(ratehotel.id) AS total_reviews,
            AVG(ratehotel.Rating) AS average_rating
        FROM 
            hotel
        LEFT JOIN 
            imageshotel ON hotel.id = imageshotel.HotelId
        LEFT JOIN 
            typeroom ON typeroom.HotelId = hotel.id
        LEFT JOIN 
            ratehotel ON ratehotel.HotelId = hotel.id
        WHERE 
            hotel.Address LIKE '%" . $provinceName . "%'
        GROUP BY 
            hotel.Name, hotel.Address, hotel.IsActive, hotel.id, imageshotel.FileName
        LIMIT 1
");

        return $hotels;
    }
}
