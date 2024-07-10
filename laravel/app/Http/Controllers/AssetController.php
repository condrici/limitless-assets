<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repository\AssetRepository;
use Illuminate\Http\RedirectResponse;


class AssetController extends Controller
{
    public function __construct(
        private AssetRepository $assetRepository
    )
    {
    }

    public function getAssets(Request $request): Response
    {
        $params = $request->all();
        $page = $request->query('page') ?? 1;
        $limit = $request->query('limit') ?? 10;

        unset ($params['limit']);
        unset ($params['page']);

        $assets = $this->assetRepository->getFiltered(
            $params, $page, $limit
        )->toArray();

        return $this->generateResponse($assets, Response::HTTP_OK);
    }

    public function getAssetById(int $id): Response
    {
        $assets = $this->assetRepository->getById($id)->toArray();
        return $this->generateResponse($assets, Response::HTTP_OK);
    }

    public function createAsset(Request $request): Response
    {
        $validated = $request->validate([
            'name' => 'required|max:255'
        ]);

        $asset = $this->assetRepository->create(
            $request->all()
        )->toArray();

        return $this->generateResponse($asset, Response::HTTP_OK);
    }

    public function deleteAsset(int $id): Response
    {
        $deleteAsset = $this->assetRepository->deleteById($id);
        return $this->generateResponse([], Response::HTTP_OK);
    }

    public function updateAsset(int $id, Request $request): Response
    {
        $validated = $request->validate([
            'name' => 'required|max:255'
        ]);

        $x = $this->assetRepository->updatePatchById($id, $request->all());
        return $this->generateResponse($x->toArray(), Response::HTTP_OK);
    }

    private function generateResponse(array $array, int $httpCode): Response
    {
        $json = json_encode($array, JSON_PRETTY_PRINT);
        return response($json, $httpCode)->header('Content-Type', 'text/javascirpt');
    }
}
