<?php

namespace App\Repositories\Hotel;

use App\Models\Hotel_Model;
use App\Models\ImagesHotel_Model;
use App\Repositories\BaseRepository;
use App\Repositories\ConvenientHotel\IConvenientHotelRepository;
use App\Repositories\Hotel\IHotelRepository;
use App\Repositories\ImagesHotel\IImagesHotelRepository;
use App\Repositories\PolicyHotel\IPolicyHotelRepository;
use App\Repositories\RateHotel\IRateHotelRepository;
use App\Repositories\TypeRoom\ITypeRoomRepository;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\DB;

class HotelRepository extends BaseRepository implements IHotelRepository
{
    protected $IImagesHotelRepository;
    protected $IConvenientHotelRepository;
    protected $IPolicyHotelRepository;
    protected $ITypeRoomRepository;
    protected $IRateHotelRepository;
    public function __construct(
        Hotel_Model $model,
        IImagesHotelRepository $IImagesHotelRepository,
        IConvenientHotelRepository $IConvenientHotelRepository,
        IPolicyHotelRepository $IPolicyHotelRepository,
        ITypeRoomRepository $ITypeRoomRepository,
        IRateHotelRepository $IRateHotelRepository
    ) {
        parent::__construct($model);
        //$this->ImagesHotelRepository =app(IImagesHotelRepository::class,['model'=>new ImagesHotel_Model()]);
        $this->IImagesHotelRepository = $IImagesHotelRepository;
        $this->IConvenientHotelRepository = $IConvenientHotelRepository;
        $this->IPolicyHotelRepository = $IPolicyHotelRepository;
        $this->ITypeRoomRepository = $ITypeRoomRepository;
        $this->IRateHotelRepository = $IRateHotelRepository;
    }
    public function paginate($page)
    {
        $models = $this->model::with(['images', 'convenients', 'policies', 'typeRooms', 'rates'])->paginate($page);

        return $models;
    }

    public function getById($id)
    {
        $model = parent::getById($id);
        if ($model instanceof Hotel_Model) {
            //lay danh sach hinh anh cua phong
            $model->images[] = $this->IImagesHotelRepository->where('HotelId', $model->id, '=');
            $model->convenients[] = $this->IConvenientHotelRepository->where('HotelId', $model->id, '=');
            $model->policies[] = $this->IPolicyHotelRepository->where('HotelId', $model->id, '=');
            $model->typeRooms[] = $this->ITypeRoomRepository->where('HotelId', $model->id, '=');
            $model->rates[] = $this->IRateHotelRepository->where('HotelId', $model->id, '=');

            return $model;
        }
        return null;
    }

    public function search(
        $Location,
        $TimeCheckIn = null,
        $QuantityMember = null,
        $MaxRoomCount = null,
        $QuantityDay = null
    ) {
        $query = "";
        $hotels = null;

        $hotels = $this->model::with(['images', 'convenients', 'policies', 'typeRooms', 'rates'])
            ->join('room as r', 'r.TypeRoomId', '=', 'tr.id')
            ->leftJoin('typeroom as tr', 'tr.HotelId', '=', 'id')
            // ->select('ht.*')
            ->where('Address', 'LIKE', '%' . $Location . '%')
            ->where('tr.MaxQuantityMember', $QuantityMember)
            ->whereYear('r.TimeRecive', '=', date('Y', strtotime($TimeCheckIn)))
            ->whereMonth('r.TimeRecive', '=', date('m', strtotime($TimeCheckIn)))
            ->whereDay('r.TimeRecive', '=', date('d', strtotime($TimeCheckIn)))
            ->whereRaw('DATEDIFF(r.TimeLeave, r.TimeRecive) = ?', [$QuantityDay])
            ->limit(10)
            ->get();

        // if ($Location != null) {
        //     $hotels = $this->model::where('Address', 'like', "%" . $Location . "%")->get();
        // } else if ($Location != null && $TimeCheckIn != null) {
        //     $query = "SELECT  ht.*
        //     FROM   `room` r, `typeroom` tr
        //     LEFT JOIN `hotel` ht ON tr.HotelId =ht.id
        //     WHERE 1 = 1 
        //     AND ht.Address LIKE N'%" . $Location . "%'
        //     AND YEAR(r.TimeRecive) = YEAR('" . $TimeCheckIn . "')
        //     AND MONTH(r.TimeRecive)=MONTH('" . $TimeCheckIn . "')
        //     AND DAY(r.TimeRecive)=DAY('" . $TimeCheckIn . "')
        //     LIMIT 10 ";
        //     $hotels = DB::select($query);
        // } else if ($Location != null && $TimeCheckIn != null && $QuantityMember != null) {
        //     $query = "SELECT  ht.*
        //     FROM   `room` r, `typeroom` tr
        //     LEFT JOIN `hotel` ht ON tr.HotelId =ht.id
        //     WHERE 1 = 1 
        //     AND ht.Address LIKE N'%" . $Location . "%'
        //     AND tr.MaxQuantityMember=" . $QuantityMember . "
        //     AND YEAR(r.TimeRecive) = YEAR('" . $TimeCheckIn . "')
        //     AND MONTH(r.TimeRecive)=MONTH('" . $TimeCheckIn . "')
        //     AND DAY(r.TimeRecive)=DAY('" . $TimeCheckIn . "')
        //     LIMIT 10 ";
        //     $hotels = DB::select($query);
        // } else if ($Location != null && $TimeCheckIn != null && $QuantityDay != null) {
        //     $query = "SELECT  ht.*
        //     FROM   `room` r, `typeroom` tr
        //     LEFT JOIN `hotel` ht ON tr.HotelId =ht.id
        //     WHERE 1 = 1 
        //     AND ht.Address LIKE N'%" . $Location . "%'
        //     AND YEAR(r.TimeRecive) = YEAR('" . $TimeCheckIn . "')
        //     AND MONTH(r.TimeRecive)=MONTH('" . $TimeCheckIn . "')
        //     AND DAY(r.TimeRecive)=DAY('" . $TimeCheckIn . "')
        //     AND DATEDIFF( R.TimeLeave,R.TimeRecive)=" . $QuantityDay . "
        //     LIMIT 10 ";
        //     $hotels = DB::select($query);
        // } else if ($Location != null && $TimeCheckIn != null && $QuantityMember != null && $MaxRoomCount != null) {
        //     $query = "SELECT  ht.*
        //     FROM   `room` r, `typeroom` tr
        //     LEFT JOIN `hotel` ht ON tr.HotelId =ht.id
        //     WHERE 1 = 1 
        //     AND ht.Address LIKE N'%" . $Location . "%'
        //     AND tr.MaxQuantityMember=" . $QuantityMember . "
        //     AND YEAR(r.TimeRecive) = YEAR('" . $TimeCheckIn . "')
        //     AND MONTH(r.TimeRecive)=MONTH('" . $TimeCheckIn . "')
        //     AND DAY(r.TimeRecive)=DAY('" . $TimeCheckIn . "')
        //     AND DATEDIFF( R.TimeLeave,R.TimeRecive)=" . $QuantityDay . "
        //     LIMIT 10 ";
        //     $hotels = DB::select($query);
        // }

        // if ($hotels != null) {
        //     foreach ($hotels as $hotel) {
        //         $hotel->images[] = $this->IImagesHotelRepository->where('HotelId', $hotel->id, '=');
        //         // if (empty((array) end($hotel->images))) {

        //         //     unset($hotel->images[count($hotel->images) - 1]);
        //         // }
        //     }
        // }
        return $hotels;
    }


  



   
}
