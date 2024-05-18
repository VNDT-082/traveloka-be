<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Districts\IDistrictsService;
use Illuminate\Http\Request;

class Districts_Controller extends Controller
{
    protected $IDistrictsService;
    public function __construct(IDistrictsService $IDistrictsService)
    {
        $this->IDistrictsService = $IDistrictsService;
    }
    public function getListByProvinceID(Request $request)
    {
        if ($request->query('id')) {
            $id = $request->query('id');
            $response = $this->IDistrictsService->getListByProvinceID($id);
            return $response ? ['status' => 200, 'result' => $response]
                : ['status' => 200, 'result' => 'NOT_FOUND'];
        }
        return ['status' => 404, 'result' => 'NOT_FOUND'];
    }
}
