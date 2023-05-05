<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeckIdRequest;
use App\Models\Deck;
use App\Models\DeckOwner;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

//CRUD DECK
class DeckController extends Controller
{
    //CREATE
    function create(Request $request){
        $deck = new Deck();
        $deck->name = $request->input('name');
        $deck->fk_language =  $request-> input('fk_language');
        $deck->save();
        $deck_owner = new DeckOwner();
        $deck_owner->fk_user = $request->user()->id;
        $deck_owner->fk_deck = $deck->id;
        $deck_owner->save();
        return response()->json(['successful'=>true, 'message'=>'Creación exitosa', 'data'=>$deck, 'propietario'=>$deck_owner]);
    }
    //DELETE
    function delete(Request $request,string $id){
        if($request->route('id') &&  is_numeric($request->route('id'))){
            try{
                $deck = Deck::findOrFail($id);
                $deck->delete();
                return response()->json(['successful'=>true, 'message'=>'Registro eliminado correctamente'], 204);

            }catch (ModelNotFoundException $err){
                return response()->json(['successful'=>false, 'message'=>'Registro no encontrado'], 404);

            }
        }
        return response()->json(['successful'=>false, 'message'=>'Parametros incorrectos'], 400);
    }

    //READ ALL DECKS
    function getAll(Request $request){
        try{
            $decks= $request->user()->decks;
            // $registros = Deck::whereAs
            return response()->json(['successful'=>true, 'message'=>'Registros encontrados', 'data'=>$decks]);

        }catch (ModelNotFoundException $err){
            return response()->json(['successful'=>false, 'message'=>'Registro no encontrado'], 404);

        }
    }


    //READ AN DECK
    function getById(Request $request, $id){
        if($request->route('id') &&  is_numeric($request->route('id'))){
            try{
                $userId = $request->user()->id;
                $deck = Deck::getDeckByIdAndUser($id, $userId);
                return response()->json(['successful'=>true, 'message'=>'Registro encontrado', 'data'=>$deck]);
                

            }catch (ModelNotFoundException $err){
                return response()->json(['successful'=>false, 'message'=>'Registro no encontrado'], 404);

            }
        }
        return response()->json(['successful'=>false, 'message'=>'Parametros incorrectos'], 400);
    }

}