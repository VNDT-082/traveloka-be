<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Room\IRoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $IRoomService;
    public function __construct(IRoomService $IRoomService)
    {
        $this->IRoomService = $IRoomService;
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
    }

    public function getListByTypeRoomID(Request $request)
    {
        if ($request->query('typeRoomID')) {
            $typeRoomID = $request->query('typeRoomID');
            if ($this->IRoomService->getListByTypeRoomID($typeRoomID)->count() > 0)
                return [
                    'result' => $this->IRoomService->getListByTypeRoomID($typeRoomID),
                    'total' => $this->IRoomService->count()
                ];
        }
        return [
            'result' => null,
            'total' => 0
        ];
    }
    public function getOneById(Request $request)
    {
        if ($request->query('id')) {
            $id = $request->query('id');
            $response = $this->IRoomService->getOneById($id);
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
