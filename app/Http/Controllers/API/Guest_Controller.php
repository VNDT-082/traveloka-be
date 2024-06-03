<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Guest\IGuestService;
use Illuminate\Http\Request;

class Guest_Controller extends Controller
{
    protected $IGuestService;
    public function __construct(IGuestService $IGuestService)
    {
        $this->IGuestService = $IGuestService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return 'appp';
    }
    public function getOneById(Request $request)
    {
        if ($request->query('id')) {
            $id = $request->query('id');
            $response = $this->IGuestService->getOneById($id);
            return $response ? ['status' => 200, 'result' => $response]
                : ['status' => 200, 'result' => 'NOT_FOUND'];
        }
        return ['status' => 404, 'result' => 'NOT_FOUND'];
    }
    public function getOneByEmail(Request $request)
    {
        if ($request->query('email')) {
            $email = $request->query('email');
            $response = $this->IGuestService->getOneByEmail($email);
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
