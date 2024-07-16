<?php

use Illuminate\Support\Facades\Route;
use App\Models\Customer;
use App\Http\Controllers\Api\AnalysisController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/searchCustomer', function(){
    return Customer::searchCustomers()->select('id', 'name', 'kana', 'tel')->paginate(50);
})->middleware('auth:sanctum');

Route::get('/analysis', [AnalysisController::class, 'index'])->middleware('auth:sanctum');
