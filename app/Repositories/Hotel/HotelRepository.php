<?php

namespace App\Repositories\Hotel;

use App\Models\Hotel_Model;
use App\Repositories\BaseRepository;
use App\Repositories\ConvenientHotel\IConvenientHotelRepository;
use App\Repositories\Hotel\IHotelRepository;
use App\Repositories\ImagesHotel\IImagesHotelRepository;
use App\Repositories\PolicyHotel\IPolicyHotelRepository;
use App\Repositories\RateHotel\IRateHotelRepository;
use App\Repositories\TypeRoom\ITypeRoomRepository;

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
        $this->IImagesHotelRepository = $IImagesHotelRepository;
        $this->IConvenientHotelRepository = $IConvenientHotelRepository;
        $this->IPolicyHotelRepository = $IPolicyHotelRepository;
        $this->ITypeRoomRepository = $ITypeRoomRepository;
        $this->IRateHotelRepository = $IRateHotelRepository;
    }
    public function paginate($page)
    {
        $models = parent::paginate($page);
        foreach ($models as $model) {
            //lay danh sach hinh anh cua phong
            $model->images[] = $this->IImagesHotelRepository->where('HotelId', $model->id, '=');

            //du lieu chua can su dung tai page list hotel
            //$model->convenients[] = $this->IConvenientHotelRepository->where('HotelId', $model->id, '=');
            //$model->policies[] = $this->IPolicyHotelRepository->where('HotelId', $model->id, '=');
            //$model->typeRooms[] = $this->ITypeRoomRepository->where('HotelId', $model->id, '=');
        }
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

    public function search($Location, $TimeCheckIn, $TimeCheckOut, $QuantityMember, $MaxRoomCount)
    {
        //Viet query 
        // SELECT *FROM `hotel` ht
        // LEFT JOIN `typeroom` tr ON ht.id=tr.HotelId 
        // WHERE 1
        // AND `Address` LIKE N'%Đà Nẵng%'
        // AND tr.MaxQuantityMember=5
        // GROUP BY ht.id
        // LIMIT 10 
    }
}
