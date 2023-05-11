<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\WordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login',[AuthController::class, 'login']);
Route::post('/register', [AuthController::class,'register']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();

//});

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function(Request $request){
        return $request->user();
    });
    //DECKS
    Route::get('/deck/{id}', [DeckController::class, 'getById']);
    Route::get('/deck', [DeckController::class, 'getAll']);
    Route::post('/create-deck',[DeckController::class, 'create']);
    Route::delete('/deck/{id}',[DeckController::class, 'delete']);

    //WORDS
    // Route::get('/word/{id}', [WordController::class, 'getById']);
    Route::get('/word/{fk_deck}', [WordController::class, 'getAll']);
    Route::post('/insert-word',[WordController::class, 'insertWord']);
    Route::delete('/word/{id}',[WordController::class, 'delete']);
    Route::post('/update/{id}',[WordController::class, 'update']);
    Route::fallback(function(){
        return response()->json([
            'success'=>false,
            'message'=> 'Error en la autenticación. Token no valido'
        ],401);
    });
});
