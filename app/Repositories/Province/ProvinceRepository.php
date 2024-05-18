<?php

namespace App\Repositories\Province;

use App\Models\Province_Model;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class ProvinceRepository extends BaseRepository implements IProvinceRepository
{
    public function __construct(Province_Model $model)
    {
        parent::__construct($model);
    }
    public function getAll()
    {
        //::with(['hotel', 'hotel.images', 'hotel.typeRooms.room'])
        //$responses = $this->model->all();
        // ::with(['hotels', 'hotels.images', 'hotels.typeRooms.room'])
        //     ->leftJoin('hotel as ht', 'ht.Province_Id', '=', 'province.id')
        //     ->leftJoin('imageshotel as im', function ($join) {
        //         $join->on('im.HotelId', '=', 'ht.id')
        //             ->where('im.TypeRoom', '=', 'None;Ảnh bìa');
        //     })

        //     ->get();
        //dd($responses);
        $qurey = 'SELECT * FROM province WHERE
            (SELECT COUNT(*) FROM hotel WHERE hotel.Province_Id=province.id)>0';


        return DB::select($qurey);
    }
}
