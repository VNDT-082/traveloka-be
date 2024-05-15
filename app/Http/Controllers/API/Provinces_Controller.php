<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Provinces\IProvincesService;
use Illuminate\Http\Request;

class Provinces_Controller extends Controller
{
    protected $IProvincesService;
    public function __construct(IProvincesService $IProvincesService)
    {
        $this->IProvincesService = $IProvincesService;
    }
    public function getAll()
    {
        $response = $this->IProvincesService->getAll();
        return $response ? ['status' => 200, 'result' => $response]
            : ['status' => 200, 'result' => 'NOT_FOUND'];
    }
}
