<?php

namespace App\Repository;

use App\Models\Asset;

class AssetRepository
{
    public function getAllAssets()
    {
        return Asset::all();
    }
  
    public function getById(int $id)
    {
        return Asset::all(['id' => $id]);
    }
}
