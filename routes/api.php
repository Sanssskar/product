<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get("/categories", [CategoryController::class, 'index']);
    Route::get("/category/{id}", [CategoryController::class, 'show']);
    // Route::post("/category", [CategoryController::class, 'store']);
    // Route::patch("/category/{id}", [CategoryController::class, 'update']);
    // Route::delete("/category/{id}", [CategoryController::class, 'delete']);


    Route::get("/products", [ProductController::class, 'index']);
    Route::get("/product/{id}", [ProductController::class, 'show']);
    // Route::post("/product", [ProductController::class, 'store']);
    // Route::patch("/product", [ProductController::class, 'update']);
    // Route::delete("/product", [ProductController::class, 'delete']);


    Route::get("/carts", [CartController::class, 'index']);
    Route::get("/cart/{id}", [CartController::class, 'show']);
    Route::post("/cart", [CartController::class, 'store']);
    Route::patch("/cart/{id}", [CartController::class, 'update']);
    Route::delete("/cart/{id}", [CartController::class, 'remove']);

    Route::get("/orders", [OrderController::class, 'index']);
    Route::post("/order", [OrderController::class, 'store']);
    Route::patch("/order/{id}", [OrderController::class, 'update']);
    Route::delete("/order/{id}", [OrderController::class, 'delete']);


    Route::post("/logout", [AuthController::class, 'logout']);

});

Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);
