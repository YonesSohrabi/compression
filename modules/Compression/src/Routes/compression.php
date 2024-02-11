<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Product API Routes
|--------------------------------------------------------------------------
|
*/
Route::group([
    'prefix' => 'api/v1/compression'
], function ($router) {
    $router->post('/store', [\Brief\Compression\Http\Controller\CompressionController::class, 'store']);
});

