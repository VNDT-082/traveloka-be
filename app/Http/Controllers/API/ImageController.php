<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\ImagesHotel_Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\URL;

class ImageController extends Controller
{
    public $imageHotel;
    public function __construct(ImagesHotel_Model $imagesHotel_Model)
    {
        $this->imageHotel = $imagesHotel_Model;
    }

    public function upload(Request $request)
    {

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $filename);

            $id_hotel = $request->input('id_hotel');
            $id_typeroom = $request->input('id_typeroom');
            $region = $request->input('region');

            $type_room_region = $id_typeroom . ";" . $region;

            $baseUrl = URL::to('/');
            $url = Storage::url('public/images/' . $filename);
            $fullUrl = $baseUrl . $url;


            $currentDateTime = date("YmdHis");
            $randomIdImage = "image" . $currentDateTime . rand(0, 9999);


            DB::table('imageshotel')->insert([
                'id' => $randomIdImage,
                'HotelId' => $id_hotel,
                'FileName' => $fullUrl,
                'TypeRoom' => $type_room_region,
            ]);
            return response()->json(['message' => $type_room_region], 200);
        } else {
            return response()->json(['message' => 'No image uploaded'], 400);
        }
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

    public function uploadMultipleImageTypeRoom(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $images = $request->file('file');
                $regions = $request->input('region');
                $typeroom = $request->input('typeroom');
                $hotel = $request->input('hotel');
                $count = 0;
                if (count($images) === count($regions)) {
                    for ($i = 0; $i < count($images); $i++) {
                        $image = $images[$i];
                        $region = $regions[$i];
                        $filename = time() . '_' . $image->getClientOriginalName();
                        $image->storeAs('public/images', $filename);

                        $baseUrl = URL::to('/');
                        $url = Storage::url('public/images/' . $filename);
                        $fullUrl = $baseUrl . $url;

                        $type_room_region = $typeroom . ";" . $region;

                        $currentDateTime = date("YmdHis");
                        $randomIdImage = "image" . $currentDateTime . rand(0, 9999);

                        $res = DB::table('imageshotel')->insert([
                            'id' => $randomIdImage,
                            'HotelId' => $hotel,
                            'FileName' => $fullUrl,
                            'TypeRoom' => $type_room_region,
                            'created_at' => date("YmdHis")
                        ]);
                        if (!$res) {
                            return response()->json($res, 500);
                        } else {
                            $count++;
                        }
                    }
                    if (
                        $count
                        === count($images)
                    ) {
                        return response()->json($count, 200);
                    }
                } else {
                    return response()->json(['message' => 'error'], 500);
                }
            } else {
                return response()->json("No File in payload", 500);
            }
        } catch (Exception $e) {
        }
    }

    public function deleteImageByIdTypeRoom(Request $request)
    {
        try {
            $id = $request->input('id');

            // Tìm ảnh từ cơ sở dữ liệu dựa trên id
            $image = DB::table('imageshotel')->where('id', $id)->first();

            if ($image) {
                $fileName = $image->FileName;

                $url = $fileName;
                $parts = explode('/', $url);
                $fileName = end($parts);
                $filePath = storage_path('app/public/images/' . $fileName);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $res = DB::table('imageshotel')->where('id', $id)->delete();

                if ($res > 0) {
                    return response()->json(true, 200);
                } else {
                    return response()->json(false, 200);
                }
            } else {
                return response()->json(false, 200);
            }
        } catch (Exception $e) {
            return response($e, 500);
        }
    }


    public function updateCoverImage(Request $request)
    {
        $file = $request->file('file');
        $oldNameFile = $request->nameFileOld;
        $idImage = $request->idImage;

        if ($file instanceof UploadedFile && $file->isValid() && strpos($file->getMimeType(), 'image/') === 0) {
            // Lưu file vào thư mục storage của server
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/images', $filename);
            $storedPath = $file->storeAs('images', $filename);

            $baseUrl = URL::to('/');
            $url = Storage::url('public/images/' . $filename);
            $fullUrl = $baseUrl . $url;

            if ($storedPath) {

                $filePath = storage_path('app/public/images/' . $oldNameFile);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                DB::table('imageshotel')->where('id', $idImage)->update(['FileName' => $fullUrl]);

                return response()->json(true, 200);
            } else {
                return response()->json(false, 500);
            }
        } else {
            return response()->json(false, 400);
        }
    }
}
