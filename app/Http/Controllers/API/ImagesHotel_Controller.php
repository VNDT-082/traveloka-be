<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ImagesHotel\IImagesHotelService;
use Illuminate\Http\Request;

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
    public function getAvartaByHotelId(Request $request)
    {
        if ($request->query('id')) {
            $id = $request->query('id');
            $response = $this->IImagesService->getAvartaByHotelId($id);
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
}
