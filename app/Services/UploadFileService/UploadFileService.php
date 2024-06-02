<?php

namespace App\Services\UploadFileService;

use Illuminate\Http\UploadedFile;

class UploadFileService implements IUploadFileService
{
    public function uploadImage(UploadedFile $fileImage)
    {
        if (exif_imagetype($fileImage)) {
            $imageName = time() . '.' . $fileImage->extension();

            $fileImage->storeAs('public/images/rate', $imageName);

            return $imageName;
        }
        return 0;
    }
}