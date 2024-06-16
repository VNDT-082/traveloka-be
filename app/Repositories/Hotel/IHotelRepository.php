<?php

namespace App\Repositories\Hotel;

use App\Repositories\IBaseRepository;

interface IHotelRepository extends IBaseRepository
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
