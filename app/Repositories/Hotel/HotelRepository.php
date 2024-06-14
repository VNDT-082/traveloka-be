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

use function Laravel\Prompts\select;

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
        $model = parent::with(['images', 'convenients', 'policies', 'typeRooms', 'rates', 'rates.guest', 'province'])
            ->where('id', '=', $id)->first();
        // if ($model instanceof Hotel_Model) {
        //     //lay danh sach hinh anh cua phong
        //     $model->images[] = $this->IImagesHotelRepository->where('HotelId', $model->id, '=');
        //     $model->convenients[] = $this->IConvenientHotelRepository->where('HotelId', $model->id, '=');
        //     $model->policies[] = $this->IPolicyHotelRepository->where('HotelId', $model->id, '=');
        //     $model->typeRooms[] = $this->ITypeRoomRepository->where('HotelId', $model->id, '=');
        //     $model->rates[] = $this->IRateHotelRepository->where('HotelId', $model->id, '=');

        //     return $model;
        // }
        return $model;
    }
    public function getListByProvinceId($id)
    {
        return $this->model::with(['typeRooms'])->where('Province_Id', '=', $id)->get();
    }
    public function getTop5ByProvinceId($id)
    {
        return $this->model::with(['typeRooms', 'typeRooms.room'])->where('Province_Id', '=', $id)->take(5)->get();
    }

    public function search(
        $province = null,
        $totalnight = null,
        $totalmember = null,
        $totalmemberchild = null,
        $timereceive = null,
        $totalroom = null
    ) {
        $query = "";
        $hotels = null;

        // $hotels = $this->model::with(['images', 'convenients', 'policies', 'typeRooms', 'rates'])
        //     ->leftJoin('province', 'hotel.Province_Id', '=', 'province.id')
        //     ->leftJoin('typeroom', 'hotel.id', '=', 'typeroom.HotelId')
        //     ->leftJoin('room', 'typeroom.id', '=', 'room.TypeRoomId')
        //     ->where(function ($query) {
        //         $query->where('province.DisplayName', 'LIKE', '%Đà%')
        //             ->orWhereNull('province.DisplayName')
        //             ->orWhere('province.DisplayName', '');
        //     })
        //     ->where('typeroom.MaxQuantityMember', '>=', 2)
        //     ->where('room.TimeRecive', '>', DB::raw('DATE("2024-05-15")'))
        //     ->whereRaw('DATEDIFF(room.TimeLeave, room.TimeRecive) > 2')
        //     ->groupBy('hotel.id,hotel.Name,hotel.Address,hotel.Telephone,hotel.Description,hotel.LocationDetail,hotel.IsActive,hotel.TimeCheckIn,hotel.TimeCheckOut,hotel.created_at,hotel.updated_at,hotel.Type,hotel.StarRate,hotel.Province_Id')
        //     ->get();

        $query = "SELECT hotel.* FROM hotel
        LEFT JOIN province ON hotel.Province_Id=province.id
        LEFT JOIN typeroom ON hotel.id=typeroom.HotelId
        LEFT JOIN room ON typeroom.id=room.TypeRoomId
        WHERE 1=1
        AND (province.DisplayName LIKE N'%" . $province . "%' OR province.DisplayName IS NULL OR province.DisplayName='')
        AND typeroom.MaxQuantityMember>=" . $totalmember . "
        AND room.TimeRecive>  DATE('" . $timereceive . "')
        AND DATEDIFF(room.TimeLeave,room.TimeRecive)>" . $totalnight . "
        GROUP BY hotel.id,hotel.Name,hotel.Address,hotel.Telephone,hotel.Description,hotel.LocationDetail
,hotel.IsActive,hotel.TimeCheckIn,hotel.TimeCheckOut,hotel.created_at,hotel.updated_at,hotel.Type,hotel.StarRate,hotel.Province_Id";
        $hotels = DB::select($query);
        return $hotels;
    }
    public function getTop10New()
    {
        return $this->model::with(['typeRooms', 'typeRooms.room'])->latest()->limit(10)->get();
    }
}
