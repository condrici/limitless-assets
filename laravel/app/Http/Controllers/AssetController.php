<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repository\AssetRepository;
use App\Services\AssetService;

class AssetController extends Controller
{
    public function __construct(private AssetRepository $assetRepository)
    {
    }

    public function getAssets(): Response
    {
        $assets = $this->assetRepository->getAllAssets()->toArray();
        return $this->generateResponse($assets);
    }

    private function generateResponse(array $array): Response
    {
        $json = json_encode($array, JSON_PRETTY_PRINT);
        return response($json, 200)->header('Content-Type', 'text/javascirpt');
    }
}
