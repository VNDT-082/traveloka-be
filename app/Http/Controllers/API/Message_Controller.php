<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Message\IMessageService;
use Illuminate\Http\Request;

class Message_Controller extends Controller
{
    protected $IMessageService;
    public function __construct(IMessageService $IMessageService)
    {
        $this->IMessageService = $IMessageService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function getAllbyUserId(Request $request)
    {
        if ($request->query('id')) {
            $id = $request->query('id');
            $response = $this->IMessageService->getAllbyUserId($id);
            return $response ? ['status' => 200, 'result' => $response]
                : ['status' => 200, 'result' => 'NOT_FOUND'];
        }
        return ['status' => 400, 'result' => 'NOT_FOUND'];
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
