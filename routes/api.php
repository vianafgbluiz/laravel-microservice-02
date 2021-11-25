<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'success' => true,
        'message' => 'Sucesso ao retornar'
    ]);
});

Route::get('evaluations/{company}', [\App\Http\Controllers\Api\EvaluationController::class, 'index']);
Route::post('evaluations/{company}', [\App\Http\Controllers\Api\EvaluationController::class, 'store']);
