<?php

namespace App\Services\UploadFileService;


use Illuminate\Http\UploadedFile;

interface IUploadFileService
{
    public function uploadImage(UploadedFile $fileImage);
}
