<?php

namespace App\Services;

use App\Models\Asset;

class AssetService
{
    public function create(array $fields)
    {
        return Asset::create($fields);
    }
}
