<?php

namespace App\Services\Hotel;

use App\Services\IBaseService;

interface IHotelService extends IBaseService
{
    public function search(
        $province = null,
        $totalnight = null,
        $totalmember = null,
        $totalmemberchild = null,
        $timereceive = null,
        $totalroom = null
    );
    public function getListByProvinceId($id);
    public function getTop5ByProvinceId($id);
    public function getTop10New();
}
