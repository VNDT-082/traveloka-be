<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Province_Model;
use App\Services\Hotel\IHotelService;
use App\Services\ImagesHotel\IImagesHotelService;
use App\Services\Province\IProvinceService;
use App\Services\TypeRoom\ITypeRoomService;
use Illuminate\Http\Request;

class Province_Controller extends Controller
{
    protected $IProvinceService;
    protected $IHotelService;
    protected $ITypeRoomService;
    protected $IImagesHotelService;
    public function __construct(
        IProvinceService $IProvinceService,
        IHotelService $IHotelService,
        ITypeRoomService  $ITypeRoomService,
        IImagesHotelService $IImagesHotelService
    ) {
        $this->IProvinceService = $IProvinceService;
        $this->IHotelService = $IHotelService;
        $this->ITypeRoomService = $ITypeRoomService;
        $this->IImagesHotelService = $IImagesHotelService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    //Lay top 10 records dau tien
    public function paginate(Request $request)
    {
        if ($request->query('page')) {
            $page = $request->query('page');
            return [
                'result' => $this->IProvinceService->paginate($page),
                'total' => $this->IProvinceService->count()
            ];
        }
        return [
            'result' => $this->IProvinceService->paginate(1),
            'total' => $this->IProvinceService->count()
        ];
    }

    public function getAll()
    {
        $response = $this->IProvinceService->getAll();

        if (is_array($response)) {
            foreach ($response as $item) {

                $hresponse = $this->IHotelService->getTop5ByProvinceId($item->id);
                $item->hotels = $hresponse;
                foreach ($item->hotels as $ihotel) {
                    $hImageAvt = $this->IImagesHotelService->getAvartaByHotelId($ihotel->id);
                    $arr = array();
                    array_push($arr, $hImageAvt);
                    $ihotel->images = $arr;
                }
                $totalHotel = $this->IHotelService->count();
                $item->totalHotel = $totalHotel;
            }
        }
        // var_dump($response);
        return $response ? ['status' => 200, 'result' => $response]
            : ['status' => 200, 'result' => 'NOT_FOUND'];
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
