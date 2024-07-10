<?php

namespace App\Repository;

use App\Models\Asset;
use App\Exceptions\ResourceDoesNotExist;
use Illuminate\Database\Eloquent\Collection;
use App\Repository\PaginationTrait;

class AssetRepository
{
    public function getFiltered(
        array $params, 
        int $page,
        int $limit
    ): Collection
    {
        $offset = ($page -1) * $limit;

        return Asset::where($params)
            ->offset($offset)
            ->limit($limit)
            ->get();
    }
  
    public function getById(int $id): Collection
    {
        $find = Asset::find($id);
        if ($find === null) {
            throw new ResourceDoesNotExist("Asset does not exist, nothing to retrieve");
        }

        return $find;
    }

    public function create(array $params): Asset
    {
        return Asset::create($params);
    }
    
    public function updatePatchById(int $id, array $params): Asset
    {
        $asset = Asset::find($id);
        if ($asset === null) {
            throw new ResourceDoesNotExist("Asset does not exist, nothing to update");
        }

        Asset::where('id', $id)->update($params);

        return $asset->fresh();
    }

    public function deleteById(int $id): bool
    {
        Asset::find($id)?->delete();

        return true;
    }
}
