<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ConvenientHotel\IConvenientHotelService;
use App\Services\Hotel\IHotelService;
use App\Services\ImagesHotel\IImagesHotelService;
use App\Services\RateHotel\IRateHotelService;
use App\Services\TypeRoom\ITypeRoomService;
use Illuminate\Http\Request;

class Hotel_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $IHotelService;
    protected $IImagesHotelService;
    protected $ITypeRoomService;
    protected $IConvenientHotelService;
    protected $IRateHotelService;

    public function __construct(
        IHotelService $IHotelService,
        IImagesHotelService $IImagesHotelService,
        ITypeRoomService $ITypeRoomService,
        IConvenientHotelService $IConvenientHotelService,
        IRateHotelService $IRateHotelService
    ) {
        $this->IHotelService = $IHotelService;
        $this->IImagesHotelService = $IImagesHotelService;
        $this->ITypeRoomService = $ITypeRoomService;
        $this->IConvenientHotelService = $IConvenientHotelService;
        $this->IRateHotelService = $IRateHotelService;
    }

    public function index()
    {
        //lay tat ca hotel

    }
    public function paginate(Request $request)
    {
        if ($request->query('page')) {
            $page = $request->query('page');
            //dd($this->IHotelService->paginate($page));
            return [
                'result' => $this->IHotelService->paginate($page),
                'total' => $this->IHotelService->count()
            ];
        }

        return [
            'result' => $this->IHotelService->paginate(1),
            'total' => $this->IHotelService->count()
        ];
    }
    public function getHotelsByProvinceId(Request $request)
    {
        if ($request->query('id')) {
            $id = $request->query('id');
            $response = $this->IHotelService->getListByProvinceId($id);
            foreach ($response as $item) {
                $hImageAvt = $this->IImagesHotelService->getAvartaByHotelId($item->id);
                $arrImg = $this->IImagesHotelService->getTop3ImageByHotelId($item->id);
                $arr = array();
                array_push($arr, $hImageAvt);
                foreach ($arrImg as $iImg) {
                    array_push($arr, $iImg);
                }
                $item->images = $arr;

                $convenientHotel = $this->IConvenientHotelService->getListByHotelId($item->id);
                $item->convenients = $convenientHotel;

                $rateHotel = $this->IRateHotelService->getListByHotelId($item->id);
                $item->rates = $rateHotel;
            }
            return $response ? ['status' => 200, 'result' => $response]
                : ['status' => 200, 'result' => 'NOT_FOUND'];
        }
        return ['status' => 404, 'result' => 'NOT_FOUND'];
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

    public function show(Request $request)
    {
        if ($request->query('id')) {
            $id = $request->query('id');
            $response = $this->IHotelService->getById($id);
            return $response ? ['status' => 200, 'result' => $response]
                : ['status' => 200, 'result' => 'NOT_FOUND'];
        }
        return ['status' => 404, 'result' => 'NOT_FOUND'];

        //return  response()->json(['data' => 'Item' . $id], 200);
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


    public function search(Request $request)
    {
        $province = '';
        $totalnight = 0;
        $totalmember = 0;
        $totalmemberchild = 0;
        $timereceive = date('Y-m-d');
        $totalroom = 0;
        if ($request->query('province'))
            $province = $request->query('province');
        if ($request->query('totalnight'))
            $totalnight = $request->query('totalnight');
        if ($request->query('totalmember'))
            $totalmember  = $request->query('totalmember');
        if ($request->query('totalmemberchild'))
            $totalmemberchild = $request->query('totalmemberchild');
        if ($request->query('timereceive')) {
            $timereceive = $request->query('timereceive');
            //date la chuoi string dang dd/MM/yyyy
            //ket qua tra ve la yyyy/MM/dd
            // $arrDate = explode('/', $timereceive);
            // $timereceive = $arrDate[2] . '/' . $arrDate[1] . '/' . $arrDate[0];
        }
        if ($request->query('totalroom'))
            $totalroom = $request->query('totalroom');

        $response = $this->IHotelService->search(
            $province,
            $totalnight,
            $totalmember,
            $totalmemberchild,
            $timereceive,
            $totalroom
        );
        foreach ($response as $item) {
            $hImageAvt = $this->IImagesHotelService->getAvartaByHotelId($item->id);
            $arrImg = $this->IImagesHotelService->getTop3ImageByHotelId($item->id);
            $arr = array();
            array_push($arr, $hImageAvt);
            foreach ($arrImg as $iImg) {
                array_push($arr, $iImg);
            }
            $item->images = $arr;

            $typeRoomItems = $this->ITypeRoomService->getListByHotelId($item->id);
            $item->type_rooms = $typeRoomItems;

            $convenientHotel = $this->IConvenientHotelService->getListByHotelId($item->id);
            $item->convenients = $convenientHotel;

            $rateHotel = $this->IRateHotelService->getListByHotelId($item->id);
            $item->rates = $rateHotel;
        }
        return $response ? ['status' => 200, 'result' => $response]
            : ['status' => 200, 'result' => 'NOT_FOUND'];
    }
}
