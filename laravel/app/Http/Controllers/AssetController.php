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
        
        $assets = $this->assetRepository->getFiltered($params, $page, $limit);
        $count = $this->assetRepository->getFilteredCount($params);

        return $this->apiResponseBuilder
            ->withStatusCode(Response::HTTP_OK)
            ->withData($assets->toArray())
            ->withTotalMeta($count)
            ->build();
    }

    public function getAssetById(int $id): Response
    {
        $assets = $this->assetRepository->getById($id);

        return $this->apiResponseBuilder
            ->withStatusCode(Response::HTTP_OK)
            ->withData($assets->toArray())
            ->build();
    }

    public function createAsset(Request $request): Response
    {
        $validated = $request->validate([
            'name' => 'required|max:255'
        ]);

        $dto = new AssetDTO($request->all());
        $asset = $this->assetRepository->create($dto->toArray());

        return $this->apiResponseBuilder
            ->withStatusCode(Response::HTTP_OK)
            ->withData($asset->toArray())
            ->build();
    }

    public function deleteAsset(int $id): Response
    {
        $this->assetRepository->deleteById($id);

        return $this->apiResponseBuilder
            ->withStatusCode(Response::HTTP_OK)
            ->build();
    }

    public function updateAsset(int $id, Request $request): Response
    {
        $validated = $request->validate([
            'name' => 'required|max:255'
        ]);

        $dto = new AssetDTO($request->all());
        $data = $this->assetRepository->updatePatchById($id, $dto->toArray());

        return $this->apiResponseBuilder
            ->withStatusCode(Response::HTTP_OK)
            ->withData($data->toArray())
            ->build();
    }
}
