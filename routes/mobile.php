<?php
Route::post('register' , [\App\Http\Controllers\AuthController::class , 'register']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('insert/product' , [\App\Http\Controllers\productController::class , 'store']);

    Route::get('product/{id}' , [\App\Http\Controllers\productController::class , 'find']);

    Route::put ('product/{id}/update' , [\App\Http\Controllers\productController::class , 'update']);
    Route::delete('product/{id}/delete' , [\App\Http\Controllers\productController::class , 'destroy']);

    Route::get('deleted/{id}/product' ,[\App\Http\Controllers\productController::class , 'restore']);
    Route::get('user/logout' , [\App\Http\Controllers\AuthController::class , 'logout']);
    Route::get('products/search' , [\App\Http\Controllers\productController::class , 'search']);
});



