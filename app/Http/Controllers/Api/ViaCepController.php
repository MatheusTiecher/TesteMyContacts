<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LocationService;
use App\Traits\ResponseCreator;

class ViaCepController extends Controller
{
    use ResponseCreator;

    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function getViaCep($cep)
    {
        try {
            return $this->locationService->queryCep($cep);
        } catch (\Exception $e) {
            return $this->createResponseInternalError($e);
        }
    }
}
