<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\DiaDiemLanCan\IDiaDiemLanCanService;
use Illuminate\Http\Request;

class DiaDiemLanCan_Controller extends Controller
{
    protected $IDiaDiemLanCanService;
    public function __construct(IDiaDiemLanCanService $IDiaDiemLanCanService)
    {
        $this->IDiaDiemLanCanService = $IDiaDiemLanCanService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource by hotel id.
     */
    public function getListById(Request $request)
    {
        if ($request->query('id')) {
            $id = $request->query('id');
            $response = $this->IDiaDiemLanCanService->getListById($id);
            return $response ? ['status' => 200, 'result' => $response]
                : ['status' => 200, 'result' => 'NOT_FOUND'];
        }
        return ['status' => 404, 'result' => 'NOT_FOUND'];
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
    public function show(string $id)
    {
        //
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
