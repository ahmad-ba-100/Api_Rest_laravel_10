<?php

use App\Http\Controllers\EtudiantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/etudiant/liste', [EtudiantController::class, 'index']);
Route::get('/etudiant/{id}', [EtudiantController::class, 'getEtudiant']);
Route::post('createetudiant', [EtudiantController::class, 'store']);
Route::put('etudiant/edit/{id}', [EtudiantController::class, 'update']);
Route::delete('etudiant/delete/{id}', [EtudiantController::class, 'delete']);
