<?php

namespace App\Repository;

use App\Models\Asset;
use App\Exceptions\ResourceDoesNotExist;
use Illuminate\Database\Eloquent\Collection;

class AssetRepository
{
    public function getFiltered(array $params): Collection
    {
        return Asset::where($params)->get();
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
