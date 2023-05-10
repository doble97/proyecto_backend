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
        // //CODIGO ALEXIS
        // $word = $request->input('word');
        // $translation = $request->input('translation');
        // $deck = $request->input('deck');
        //     try{
        //         $comp_1 = Word::findOrFail($word);
        //     }catch (ModelNotFoundException $err){
        //         $insertion_1 = new Word();
        //         $insertion_1->name = $word;
        //         $insertion_1->save();
        //     }

        //     try{
        //         $comp_2 = Deck::findOrFail($deck);
        //     }catch (ModelNotFoundException $err){
        //         return response()->json(['successful'=>false, 'message'=>'Baraja no encontrada'], 400);
        //     }
        
        //     $insertion_2 = new DeckWord();
        //     $insertion_2->fk_word = $word;
        //     $insertion_2->fk_translation = $translation;
        //     $insertion_2->fk_deck = $deck;
        //     $insertion_2->save();
        //     return response()->json(['successful'=>true, 'message'=>'Registro creado correctamente']);
 
        // $idWord = null;
        // try{
        //     $idWord = Word::findOrFail();
        // }catch(ModelNotFoundException $err){

        // }

        //Cambios jorge
        // return response('jkl');

        $word = $request->input('word');
        $translation = $request->input('translation');
        $IdDeck = $request->input('deck');
        $wordInsertada = Word::firstOrCreate(['name'=>$word]);
        $translationInsertada = Word::firstOrCreate(['name'=>$translation]);
        try{
            $user = $request->user();
            $deck =Deck::getDeckByIdAndUser($IdDeck, $user->id);
            $deckWord = new DeckWord();
            $deckWord->fk_word = $wordInsertada->id;
            $deckWord->fk_translation = $translationInsertada->id;
            $deckWord->fk_deck = $deck->id;
            $deckWord->save();
            return response()->json(['success'=>true, 'message'=>'Carta insertada', 'data'=>$deckWord]);

        }catch (ModelNotFoundException $err){
            return response()->json(['successful'=>false, 'message'=>'Baraja no encontrada'], 400);
        }

    }

    //DELETE
    function delete(Request $request, $id){
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
    function getAll(Request $request, $fk_deck){
    //     if($request->route('$fk_word') && is_numeric($request->route('$fk_word'))){
    //         try{
    //             $userId = $request->user()->id;
    //             $deckWord = DeckWord::getDeckWordByFkWordAndUser($fk_word, $userId);           
    //         }catch (ModelNotFoundException $err){
    //             return response()->json(['successful'=>false, 'message'=>'Registro no encontrado'], 404);
    //         }
        
    //         try{
    //             $words = $request->user()->words($fk_word);
    //             return response()->json(['successful'=>true, 'message'=>'Registros encontrados', 'data'=>$words]);
    //         }catch (ModelNotFoundException $err){
    //             return response()->json(['successful'=>false, 'message'=>'Registro no encontrado'], 404);
    //         }
    // }
    // return response()->json(['successful'=>false, 'message'=>'Parametros incorrectos'], 400);
        // if($request->route('fk_word') && is_numeric($request->route('fk_word'))){
        //     try{
        //         $cartas = DeckWord::where('fk_deck',$fk_word)
        //             ->with('words')
        //             ->get(['name']);
        //         return response('funciona');
        //     }catch(Exception  $err){
        //         return response('errr');
        //     }
        // } 
        if($request->route('fk_deck') && is_numeric($request->route('fk_deck'))){
            try {
                $userId = $request->user()->id;
                $deck = Deck::getDeckByIdAndUser($fk_deck, $userId);
     
                
                // $words = DB::table('words as t1')
                //             ->join('decks_words', 't1.id', '=', 'decks_words.fk_word')
                //             ->join('words as t2', 't2.id', '=', 'decks_words.fk_translation')
                //             ->join('decks', 'decks_words.fk_deck', '=', 'decks.id')
                //             ->join('deck_owners', 'decks.id', '=', 'deck_owners.fk_deck')
                //             ->where('deck_owners.fk_user', '=', $userId)
                //             ->where('decks.id', '=', $deck->id)
                //             ->select('t1.id as idWord', 't1.name as word', 't2.id as idTranslation', 't2.name as translation')
                //             ->get();
                $words = $deck->words()
                ->select('words.id as idWord', 'words.name as word', 'translations.id as idTranslation', 'translations.name as translation')
                ->join('words as translations', 'decks_words.fk_translation', '=', 'translations.id')
                ->get();


                return response()->json(['data'=>$words]);
            } catch (ModelNotFoundException $err) {
                return response()->json(['success'=>false, 'message'=>'Baraja no encontrada']);
            }
        }
        return response('erddor');

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
    } }