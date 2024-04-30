<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ImagesHotel\IImagesHotelService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImagesHotel_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $IImagesService;
    public function __construct(IImagesHotelService $IImagesService)
    {
        $this->IImagesService = $IImagesService;
    }
    public function index()
    {
        //
        return [
            'result' => $this->IImagesService->all(),
            'total' => $this->IImagesService->count()
        ];;
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
            $response = $this->IImagesService->getById($id);
            return $response ? ['status' => 200, 'result' => $response]
                : ['status' => 200, 'result' => 'NOT_FOUND'];
        }
        return ['status' => 404, 'result' => 'NOT_FOUND'];
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

    public function upload(Request $request)
    {


        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $filename);

            // Lưu thông tin hình ảnh vào cơ sở dữ liệu
            $id_hotel = $request->input('id_hotel');
            $id_typeroom = $request->input('id_typeroom');
            $region = $request->input('region');

            $type_room_region = $id_typeroom . ";" . $region;

            
            $currentDateTime = date("YmdHis");
            $randomIdImage = "RO". $currentDateTime . rand(0, 9999);


            DB::table('imageshotel')->insert([
                'id' =>$randomIdImage,
                'HotelId' => $id_hotel,
                'FileName' => $filename,
                'TypeRoom' => $type_room_region,
            ]);
            return response()->json(['message' => $type_room_region], 200);
            }
            else {
            return response()->json(['message' => 'No image uploaded'], 400);

            }
    }
}
