<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RateHotel_Model;
use App\Services\Guest\IGuestService;
use App\Services\RateHotel\IRateHotelService;
use App\Services\UploadFileService\IUploadFileService;
use Exception;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RateHotel_Controller extends Controller
{
    protected $IRateHotelService;
    protected $IUploadFileService;
    protected $IGuestService;

    public function __construct(
        IRateHotelService $IRateHotelService,
        IUploadFileService $IUploadFileService,
        IGuestService $IGuestService
    ) {
        $this->IRateHotelService = $IRateHotelService;
        $this->IUploadFileService = $IUploadFileService;
        $this->IGuestService = $IGuestService;
    }


    public function addNewRate(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|string|max:50',
                'HotelId' => 'required|string|max:50',
                'GuestId' => 'required|string|max:50',
                'Rating' => 'required|integer|min:0',
                'Description' => 'required|string|max:512',
                'Sach_Se' => 'required|integer|min:0',
                'Thoai_Mai' => 'required|integer|min:0',
                'Dich_Vu' => 'required|integer|min:0',
            ]);
            $validatedData['created_at'] = now();
            $validatedData['updated_at'] = now();

            $listImageName = "";
            if ($request->validate(['imageCount' => 'required'])) {
                $imageCount = intval($request->validate(['imageCount' => 'required'])['imageCount']);
                if ($imageCount > 0) {
                    $imageOutSize = false;
                    for ($i = 0; $i < $imageCount; $i++) {
                        if ($request->validate(['image' . strval($i) => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',])) {
                            if ($request->hasFile('image' . $i)) {
                                $file = $request->file('image' . $i);
                                $path = $file->store('images/rate', 'public');
                                // $file->storeAs('public/images/rate', $imageName);
                                $listImageName == "" ? $listImageName = basename($path)
                                    : $listImageName = $listImageName . ";" . basename($path);
                            }
                        } else {
                            $imageOutSize = true;
                        }
                    }
                    if ($imageOutSize == true) {
                        return response()->json([
                            'message' => "Thêm bình đánh giá thất bại, vui lòng chọn hình ảnh nhỏ hơn bằng 2MB",
                            'status' => 'warning'
                        ], 200);
                    }
                }
            }
            $listImageName == "" ?
                $validatedData['HinhAnh'] = null :
                $validatedData['HinhAnh'] = $listImageName;

            $result = $this->IRateHotelService->create($validatedData);
            $result->guest = $this->IGuestService->getOneById($result['GuestId']);
            return response()->json([
                'message' => "Đã thêm đánh giá thành công",
                'status' => 'successfully',
                'result' => $result
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'message' => "Thêm bình đánh giá thất bại",
                'status' => 'error'
            ], 400);
        }
    }
}
