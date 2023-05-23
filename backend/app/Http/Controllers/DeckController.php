<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeckIdRequest;
use App\Models\Deck;
use App\Models\DeckOwner;
use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

//CRUD DECK
class DeckController extends Controller
{
    //CREATE
    function create(Request $request, $shared = null){
        $deck = new Deck();
        $deck->name = $request->input('name');
        $deck->fk_language =  $request-> input('fk_language');
        $deck->shared = $shared != null;

        $deck->save();
        $deck_owner = new DeckOwner();
        $deck_owner->fk_user = $request->user()->id;
        $deck_owner->fk_deck = $deck->id;
        $deck_owner->save();
        return response()->json(['success'=>true, 'message'=>'Creación exitosa', 'data'=>$deck]);
    }
    //DELETE
    function delete(Request $request,string $id){
        if($request->route('id') &&  is_numeric($request->route('id'))){
            try{
                $userId = $request->user()->id;
                $deck = Deck::getDeckByIdAndUser($id, $userId);
                $deck->delete();
                return response()->json([],204);

            }catch (ModelNotFoundException $err){
                return response()->json(['success'=>false, 'message'=>'Registro no encontrado'], 404);

            }
        }
        return response()->json(['success'=>false, 'message'=>'Parametros incorrectos'], 400);
    }

    //READ ALL DECKS
    function getAll(Request $request){
        try{
            $decks= $request->user()->decks; 
            // $registros = Deck::whereAs
            return response()->json(['success'=>true, 'message'=>'Registros encontrados', 'data'=>$decks]);

        }catch (ModelNotFoundException $err){
            return response()->json(['success'=>false, 'message'=>'Registro no encontrado'], 404);

        }
    }


    //READ AN DECK
    function getById(Request $request, $id){
        if($request->route('id') && is_numeric($request->route('id'))){
            try{
                $userId = $request->user()->id;
                $deck = Deck::getDeckByIdAndUser($id, $userId);
                return response()->json(['successful'=>true, 'message'=>'Registro encontrado', 'data'=>$deck]);
                

            }catch (ModelNotFoundException $err){
                return response()->json(['successful'=>false, 'message'=>'Registro no encontrado'], 404);

            }
        }
        return response()->json(['success'=>false, 'message'=>'Parametros incorrectos'], 400);
    }

    // UPDATE DECK
    function update(Request $request){
        $idDeck = $request->input('id');
        $nameInsert = $request->input('name');
        $idLanguage = $request->input('fk_language');
        $userId = $request->user()->id;
        try{
            $deck = Deck::getDeckByIdAndUser($idDeck, $userId);
        }catch(ModelNotFoundException $err){
            return response()->json(['success'=>false, 'message'=>'Error en la peticion'], 400);
        }
        
        try{
            Language::findOrFail($idLanguage);
        }catch(ModelNotFoundException $err){
            return response()->json(['success'=>false, 'message'=>'Lenguaje no encontrado']);
        }

        $deck->name = $nameInsert;
        $deck->fk_language = $idLanguage;
        $deck->save();
        return response()->json(['success'=>true, 'message'=>'Palabra actualizada', 'data'=>$deck]);
    }

    // Share Deck
    function shareDeck(Request $request){
        $idDeck = $request->input('id');
        $user = $request->user();
        try{
            $deck = Deck::getDeckByIdAndUser($idDeck, $user->id);
            $deck->shared = true;
            $deck->save();
            return response()->json(['success'=>True, 'message'=>'Baraja publicada']);
    } catch(ModelNotFoundException $err){
        return response()->json(['success'=>false, 'message'=>'Baraja no encontrada'], 400);
    }
}

    // Hide Deck
    function hideDeck(Request $request){
        $idDeck = $request->input('id');
        $user = $request->user();
        try{
            $deck = Deck::getDeckByIdAndUser($idDeck, $user->id);
            $deck->shared = false;
            $deck->save();
            return response()->json(['success'=>True, 'message'=>'Baraja ocultada']);
    } catch(ModelNotFoundException $err){
        return response()->json(['success'=>false, 'message'=>'Baraja no encontrada'], 400);
    }
}
    function showShareDeck(Request $request){
        try{
            $decks = $request->user()->decks->where('shared',1); 
            return response()->json(['success'=>true, 'message'=>'Registros encontrados', 'data'=>$decks]);

        }catch (ModelNotFoundException $err){
            return response()->json(['success'=>false, 'message'=>'Registro no encontrado'], 404);

        }
    }
    function showFollowDeck(Request $request)
    {
        $userId = $request->user()->id;
        
        $info_1 = User::join('friends', 'users.id', '=', 'friends.fk_user_send_request')
            ->where('friends.fk_user_receive_request', $userId)
            ->where('friends.state_request', 2)
            ->select('users.id')
            ->get();
        
        $info_2 = User::join('friends', 'users.id', '=', 'friends.fk_user_receive_request')
            ->where('friends.fk_user_send_request', $userId)
            ->where('friends.state_request', 2)
            ->select('users.id')
            ->get();
        
        $friendIds = $info_1->merge($info_2)->pluck('id');
        
        $decks = Deck::join('deck_owners', 'decks.id', '=', 'deck_owners.fk_deck')
            ->whereIn('deck_owners.fk_user', $friendIds)
            ->where('decks.shared', 1)
            ->select('decks.*')
            ->get();
        
        return response()->json(['success' => true, 'message' => 'Registros encontrados', 'data' => $decks]);
    }
}
