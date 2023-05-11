<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use App\Models\DeckCollaborator;
use App\Models\DeckOwner;
use App\Models\DeckWord;
use App\Models\Phrase;
use App\Models\PhraseDeckWord;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class pruebaController extends Controller
{
    function prueba(Request $request){
        try{
            PhraseDeckWord::findOrFail('1');
            return response()->json(['successful'=>true]);
        }catch(ModelNotFoundException $err){
        return response()->json(['successful'=>false]);
    }
}
}