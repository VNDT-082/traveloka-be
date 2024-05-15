<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\ImagesHotel_Model;

class ImageController extends Controller
{
    public $imageHotel;
    public function __construct(ImagesHotel_Model $imagesHotel_Model)
    {
        $this->imageHotel = $imagesHotel_Model;
    }

    public function selectImageByIdTypeRoom(Request $request)
    {
        $typeroomId = $request->typeroom;
        try {
            $sql = "SELECT * FROM imageshotel WHERE TypeRoom LIKE '%$typeroomId%'";
            $res = $this->imageHotel::where('Typeroom', 'like', "%{$typeroomId}%")->get();
            $ress = DB::select($sql);
            return response()->json($res, 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e], 404);
        }
    }
}
