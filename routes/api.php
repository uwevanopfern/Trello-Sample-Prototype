<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\ExportDBController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'columns'], function () {
    $idInThePath = '/{id}';
    Route::get('/', [ColumnController::class, 'index']);
    Route::post('/', [ColumnController::class, 'store']);
    Route::delete($idInThePath, [ColumnController::class, 'destroy']);
});

Route::group(['prefix' => 'cards'], function () {
    $idInThePath = '/{id}';
    Route::post('/', [CardController::class, 'store']);
    Route::put($idInThePath, [CardController::class, 'update']);
    Route::put($idInThePath . '/updateOrder', [CardController::class, 'updateOrder']);
});

Route::post('/tokens/create', function (Request $request) {
    $request->validate(['email' => 'required']);
    $user = User::where('email', $request->email)->first();

    if ($user) {
        $token = $user->createToken('BeMo API Token');
        return ['token' => $token->plainTextToken];
    }
});

Route::get('/export-db', [ExportDBController::class, 'exportDb']);
Route::get('/list-cards', [CardController::class, 'index'])->middleware('auth:sanctum');
