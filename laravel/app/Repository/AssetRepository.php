<?php

namespace App\Repository;

use App\Models\Asset;
use App\Exceptions\ResourceDoesNotExist;
use Illuminate\Database\Eloquent\Collection;

class AssetRepository
{
    public function __construct(private Asset $asset)
    {
    }

    public function getFiltered(
        array $params, 
        int $page,
        int $limit
    ): Collection
    {
        $offset = ($page -1) * $limit;

        return $this->asset->where($params)
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public function getFilteredCount(array $params): int
    {
        return $this->asset->where($params)->count();
    }
  
    public function getById(int $id): Collection
    {
        $find = $this->asset->find($id);
        if ($find === null) {
            throw new ResourceDoesNotExist("Asset does not exist, nothing to retrieve");
        }

        return $find;
    }

    public function create(array $params): Asset
    {
        return $this->asset->create($params);
    }
    
    public function updatePatchById(int $id, array $params): Asset
    {
        $asset = $this->asset->find($id);
        if ($asset === null) {
            throw new ResourceDoesNotExist("Asset does not exist, nothing to update");
        }

        $this->asset->where('id', $id)->update($params);

        return $asset->fresh();
    }

    public function deleteById(int $id): bool
    {
        $this->asset->find($id)?->delete();

        return true;
    }
}
