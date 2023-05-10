<?php

namespace App\Http\Controllers;
use App\Models\Word;
use App\Models\Deck;
use App\Models\DeckWord;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class WordController extends Controller
{
    //INSERT WORD IN DECK
    function insertWord(Request $request){
        $nameWord = $request->input('word');
        $nameTranslation = $request->input('translation');
        $nameDeck = $request->input('deck');

            try{
                $valuesDeck = Deck::where('name', '=', $nameDeck)->firstOrFail();
                $idDeck = $valuesDeck->id;
            }catch (ModelNotFoundException $err){
                return response()->json(['success'=>false, 'message'=>'Baraja no encontrada'], 400);
            }

            try{
                $valuesWord = Word::where('name', '=', $nameWord)->firstOrFail();
                $idWord = $valuesWord->id;
            }catch (ModelNotFoundException $err){
                $valuesWord = new Word();
                $valuesWord->name = $nameWord;
                $valuesWord->save();
                $idWord = $valuesWord->id;
            }

            try{
                $valuesTranslation = Word::where('name', '=', $nameTranslation)->firstOrFail();
                $idTranslation = $valuesTranslation->id;
            }catch (ModelNotFoundException $err){
                $valuesTranslation = new Word();
                $valuesTranslation->name = $nameTranslation;
                $valuesTranslation->save();
                $idTranslation = $valuesTranslation->id;
            }

            $insertion = new DeckWord();
            $insertion->fk_word = $idWord;
            $insertion->fk_translation = $idTranslation;
            $insertion->fk_deck = $idDeck;
            $insertion->save();
            return response()->json(['success'=>true, 'message'=>'Registro creado correctamente']);
    }

    //DELETE
    function delete(Request $request,string $id){
        if($request->route('id') &&  is_numeric($request->route('id'))){
            try{
                $word = DeckWord::findOrFail($id);
                $word->delete();
                return response()->json(['successful'=>true, 'message'=>'Registro eliminado correctamente'], 204);

            }catch (ModelNotFoundException $err){
                return response()->json(['successful'=>false, 'message'=>'Registro no encontrado'], 404);

            }
        }
        return response()->json(['successful'=>false, 'message'=>'Parametros incorrectos'], 400);
    }

    //READ ALL WORDS ON A DECK
    function getAll(Request $request, $fk_word){
        if($request->route('$fk_word') && is_numeric($request->route('$fk_word'))){
            try{
                $userId = $request->user()->id;
                $deckWord = DeckWord::getDeckWordByFkWordAndUser($fk_word, $userId);           
            }catch (ModelNotFoundException $err){
                return response()->json(['successful'=>false, 'message'=>'Registro no encontrado'], 404);
            }
        
            try{
                $words = $request->user()->words($fk_word);
                return response()->json(['successful'=>true, 'message'=>'Registros encontrados', 'data'=>$words]);
            }catch (ModelNotFoundException $err){
                return response()->json(['successful'=>false, 'message'=>'Registro no encontrado'], 404);
            }
    }
    return response()->json(['successful'=>false, 'message'=>'Parametros incorrectos'], 400);
}


    //READ AN WORD ON A DECK
    function getById(Request $request, $id){
        if($request->route('$id') && is_numeric($request->route('$id'))){
            try{
                $userId = $request->user()->id;
                $deckWord = DeckWord::getDeckWordByIdAndUser($id, $userId);
                return response()->json(['successful'=>true, 'message'=>'Registro encontrado', 'data'=>$deckWord]);
                

            }catch (ModelNotFoundException $err){
                return response()->json(['successful'=>false, 'message'=>'Registro no encontrado'], 404);

            }
        }
        return response()->json(['successful'=>false, 'message'=>'Parametros incorrectos'], 400);
    }

  // function prueba(Request $request){
  //          try{
    //            $valuesDeck = DeckCollaborator::findOrFail('1');
      //          return response()->json(['success'=>true]);
        //    }catch (ModelNotFoundException $err){
          //      return response()->json(['success'=>false, 'message'=>'Parametros incorrectos'], 400);
            //}
    //}
}