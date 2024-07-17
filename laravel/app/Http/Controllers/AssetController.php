<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repository\AssetRepository;
use Illuminate\Http\RedirectResponse;
use App\DTO\AssetDTO;
use App\Http\Response\ApiResponseBuilder;


class AssetController extends Controller
{
    public function __construct(
        private AssetRepository $assetRepository,
        private ApiResponseBuilder $apiResponseBuilder
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

        $count = $this->assetRepository->getFilteredCount(
            $params
        );

        return $this->apiResponseBuilder
            ->withStatusCode(Response::HTTP_OK)
            ->withData($assets)
            ->withTotalMeta($count)
            ->build();
    }

    public function getAssetById(int $id): Response
    {
        $assets = $this->assetRepository->getById($id)->toArray();
        return $this->generateResponse(Response::HTTP_OK, $assets);
    }

    public function createAsset(Request $request): Response
    {
        $validated = $request->validate([
            'name' => 'required|max:255'
        ]);

        $dto = new AssetDTO($request->all());

        $asset = $this->assetRepository->create(
            $dto->toArray()
        )->toArray();

        return $this->generateResponse(Response::HTTP_OK, $asset);
    }

    public function deleteAsset(int $id): Response
    {
        $deleteAsset = $this->assetRepository->deleteById($id);
        return $this->generateResponse(Response::HTTP_OK);
    }

    public function updateAsset(int $id, Request $request): Response
    {
        $validated = $request->validate([
            'name' => 'required|max:255'
        ]);

        $dto = new AssetDTO($request->all());

        $x = $this->assetRepository->updatePatchById($id, $dto->toArray());
        return $this->generateResponse(Response::HTTP_OK, $x->toArray());
    }

    private function generateResponse(
        int $httpCode, 
        ?array $httpResponseData = null, 
        ?string $error = null,
        $count
    ): Response
    {
        $result = [];
        // $result['success'] = substr($httpCode, 0, 1) === 2 ? true : false;
        $result['success'] = true;

        if ($httpResponseData) {
            $result['data'] = $httpResponseData;
        }

        if ($error) {
            $result['error'] = $error;
        }

        $result['meta']['total'] = $count;

        $json = json_encode($result, JSON_PRETTY_PRINT);
        return response($json, $httpCode)->header('Content-Type', 'text/javascirpt');
    }
}
