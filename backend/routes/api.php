<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeckController;
use App\Models\Deck;
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

// });

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function(Request $request){
        return $request->user();
    });
    //DECKS
    Route::get('/deck/{id}', [DeckController::class, 'getById']);
    Route::get('/deck', [DeckController::class, 'getAll']);
    Route::post('/create-deck',[DeckController::class, 'create']);
    Route::delete('/deck/{id}',[DeckController::class, 'delete']);
});
