<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Poster\IPosterService;
use Exception;
use Illuminate\Http\Request;

class Poster_Controller extends Controller
{
    protected $IPosterService;
    public function __construct(IPosterService $IPosterService)
    {
        $this->IPosterService = $IPosterService;
    }
    public function getOneByGitCode(Request $request)
    {
        if ($request->query('giftcode')) {
            $giftCode = $request->query('giftcode');
            $response = $this->IPosterService->getOneByGitCode($giftCode);
            return $response ? ['status' => 200, 'result' => $response]
                : ['status' => 200, 'result' => 'NOT_FOUND'];
        }
        return ['status' => 404, 'result' => 'NOT_FOUND'];
    }

    public function getOneById(Request $request)
    {
        if ($request->query('id')) {
            $id = $request->query('id');
            $response = $this->IPosterService->getOneById($id);
            return $response ? ['status' => 200, 'result' => $response]
                : ['status' => 200, 'result' => 'NOT_FOUND'];
        }
        return ['status' => 404, 'result' => 'NOT_FOUND'];
    }
    public function getAllHaveGitCode()
    {
        try {
            $response = $this->IPosterService->getAllHaveGitCode();
            return $response ? ['status' => 200, 'result' => $response]
                : ['status' => 200, 'result' => 'NOT_FOUND'];
        } catch (Exception $ex) {
            return ['status' => 500, 'result' => 'NOT_FOUND'];
        }
    }
}
