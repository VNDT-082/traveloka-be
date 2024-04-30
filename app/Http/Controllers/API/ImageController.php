<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
        use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {

// Kiểm tra và tạo thư mục nếu chưa tồn tại
if (!Storage::exists('public/images')) {
    Storage::makeDirectory('public/images');
}

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

            $randomIdImage = "AC". $currentDateTime;

            // Lưu thông tin hình ảnh vào cơ sở dữ liệu
            DB::table('imageshotel')->insert([
                'id' =>$randomIdImage,
                'FileName' => $filename,
                'HotelId' => $id_hotel,
                'TypeRoom' => $type_room_region,

            ]);

            return response()->json(['message' => 'Image uploaded successfully'], 200);
        } else {
            return response()->json(['message' => 'No image uploaded'], 400);
        }
    }
}
