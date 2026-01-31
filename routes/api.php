<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get("/category", [CategoryController::class, 'index']);
    Route::post("/category", [CategoryController::class, 'store']);
    Route::patch("/category/{id}", [CategoryController::class, 'update']);
    Route::delete("/category/{id}", [CategoryController::class, 'delete']);


    Route::get("/product", [ProductController::class, 'index']);
    Route::post("/product", [ProductController::class, 'store']);
    Route::patch("/product", [ProductController::class, 'update']);
    Route::delete("/product", [ProductController::class, 'delete']);

    Route::post("/logout",[AuthController::class,'logout']);
});

Route::post("/register",[AuthController::class,'register']);
Route::post("/login",[AuthController::class,'login']);
