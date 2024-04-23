<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Province\IProvinceService;
use Illuminate\Http\Request;

class Province_Controller extends Controller
{
    protected $IProvinceService;
    public function __construct(IProvinceService $IProvinceService)
    {
        $this->IProvinceService = $IProvinceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    //Lay top 10 records dau tien
    public function paginate(Request $request)
    {
        if ($request->query('page')) {
            $page = $request->query('page');
            return [
                'result' => $this->IProvinceService->paginate($page),
                'total' => $this->IProvinceService->count()
            ];
        }
        return [
            'result' => $this->IProvinceService->paginate(1),
            'total' => $this->IProvinceService->count()
        ];
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
