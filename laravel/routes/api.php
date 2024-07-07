<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
| INFO
| 
| By default, all api routes are preixed with /api/your-route-here
| This prefix can be changed in the RouteServiceProvider class
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/assets', [AssetController::class, 'getAssets']);
Route::get('/assets/{id}', [AssetController::class, 'getAssetById']);
Route::post('/assets', [AssetController::class, 'createAsset']);
Route::delete('/assets/{id}', [AssetController::class, 'deleteAsset']);
Route::patch('/assets/{id}', [AssetController::class, 'updateAsset']);