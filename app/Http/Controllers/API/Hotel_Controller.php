<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Hotel\IHotelService;
use Illuminate\Http\Request;

class Hotel_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $IHotelService;
    public function __construct(IHotelService $IHotelService)
    {
        $this->IHotelService = $IHotelService;
    }
    public function index()
    {
        //lay tat ca hotel

    }
    public function paginate(Request $request)
    {
        if ($request->query('page')) {
            $page = $request->query('page');
            //dd($this->IHotelService->paginate($page));
            return [
                'result' => $this->IHotelService->paginate($page),
                'total' => $this->IHotelService->count()
            ];
        }

        return [
            'result' => $this->IHotelService->paginate(1),
            'total' => $this->IHotelService->count()
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

    public function show(Request $request)
    {
        if ($request->query('id')) {
            $id = $request->query('id');
            $response = $this->IHotelService->getById($id);
            return $response ? ['status' => 200, 'result' => $response]
                : ['status' => 200, 'result' => 'NOT_FOUND'];
        }
        return ['status' => 404, 'result' => 'NOT_FOUND'];

        //return  response()->json(['data' => 'Item' . $id], 200);
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

    public function search(Request $request)
    {
        if ($request->query('Location')) {
            $Location = $request->query('Location');
            $TimeCheckIn = $request->query('TimeCheckIn') ? $request->query('TimeCheckIn') : null;
            $QuantityMember = $request->query('QuantityMember') ? $request->query('QuantityMember') : null;
            $MaxRoomCount = $request->query('MaxRoomCount') ? $request->query('MaxRoomCount') : null;
            $QuantityDay = $request->query('QuantityDay') ? $request->query('QuantityDay') : null;
            $response = $this->IHotelService->search($Location, $TimeCheckIn, $QuantityMember, $MaxRoomCount, $QuantityDay);
            dd($response);
            return $response ? ['status' => 200, 'result' => $response]
                : ['status' => 200, 'result' => 'NOT_FOUND'];
        }
        return ['status' => 404, 'result' => 'NOT_FOUND'];
    }
}
