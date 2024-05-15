<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Wards\IWardsService;
use Illuminate\Http\Request;

class Wards_Controller extends Controller
{
    protected $IWardsService;
    public function __construct(IWardsService $IWardsService)
    {
        $this->IWardsService = $IWardsService;
    }
    public function getListByDistrictID(Request $request)
    {
        if ($request->query('id')) {
            $id = $request->query('id');
            $response = $this->IWardsService->getListByDistrictID($id);
            return $response ? ['status' => 200, 'result' => $response]
                : ['status' => 200, 'result' => 'NOT_FOUND'];
        }
        return ['status' => 404, 'result' => 'NOT_FOUND'];
    }
}
