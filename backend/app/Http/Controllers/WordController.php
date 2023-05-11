<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\Deck;
use App\Models\DeckWord;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WordController extends Controller
{
    //INSERT WORD IN DECK
    function insertWord(Request $request){

        $word = $request->input('word');
        $translation = $request->input('translation');
        $IdDeck = $request->input('deck');
        $wordInsertada = Word::firstOrCreate(['name'=>$word]);
        $translationInsertada = Word::firstOrCreate(['name'=>$translation]);
        try{
            $user = $request->user();
            $deck = Deck::getDeckByIdAndUser($IdDeck, $user->id);
            $deckWord = new DeckWord();
            $deckWord->fk_word = $wordInsertada->id;
            $deckWord->fk_translation = $translationInsertada->id;
            $deckWord->fk_deck = $deck->id;
            $deckWord->save();
            return response()->json(['success'=>true, 'message'=>'Carta insertada', 'data'=>$deckWord]);

        }catch (ModelNotFoundException $err){
            return response()->json(['success'=>false, 'message'=>'Baraja no encontrada'], 400);
        }

    }

    //DELETE
    function delete(Request $request, $id){
        if($request->route('id') &&  is_numeric($request->route('id'))){
            try{
                $userId = $request->user()->id;
                $DeckWordRegister = DeckWord::findOrFail($id);
                $DeckWordRegister->delete();
                return response()->json(['success'=>true, 'message'=>'registro eliminado correctamente'],204);

            }catch (ModelNotFoundException $err){
                return response()->json(['success'=>false, 'message'=>'Registro no encontrado'], 404);

            }
        }
        return response()->json(['success'=>false, 'message'=>'Parametros incorrectos'], 400);
    }
    //READ ALL WORDS ON A DECK
    function getAll(Request $request, $fk_deck){
        if($request->route('fk_deck') && is_numeric($request->route('fk_deck'))){
            try {
                $userId = $request->user()->id;
                $deck = Deck::getDeckByIdAndUser($fk_deck, $userId);
     
                $words = $deck->words()
                ->select('words.id as idWord', 'words.name as word', 'translations.id as idTranslation', 'translations.name as translation', 'decks_words.id as idDecksWords')
                ->join('words as translations', 'decks_words.fk_translation', '=', 'translations.id')
                ->get();

                return response()->json(['success'=>true, 'message'=>'Enviando cartas','data'=>$words]);
            } catch (ModelNotFoundException $err) {
                return response()->json(['success'=>false, 'message'=>'Baraja no encontrada']);
            }
        }
        return response()->json(['success'=>false, 'message'=>'Error en la peticion'], 400);

}

    // UPDATE WORD
    function update(Request $request, $id){
        if($request->route('id') && is_numeric($request->route('id'))){
            try{
            $wordInsert = $request->input('word');
            $translationInsert = $request->input('translation'); 
            $word = Word::firstOrCreate(['name'=>$wordInsert]);
            $translation = Word::firstOrCreate(['name'=>$translationInsert]);
            $deckWord = DeckWord::findOrFail($id);
            $deckWord->fk_word = $word->id;
            $deckWord->fk_translation = $translation->id;
            $deckWord->save();
            return response()->json(['success'=>true, 'message'=>'Palabra actualizada', 'data'=>$deckWord]);
            } catch(ModelNotFoundException $err){
                return response()->json(['success'=>false, 'message'=>'Registro no encontrado'], 404);
            } 
    }
    return response()->json(['success'=>false, 'message'=>'Error en la peticion'], 400);
}}