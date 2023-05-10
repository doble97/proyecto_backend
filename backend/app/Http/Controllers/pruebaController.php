<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class pruebaController extends Controller
{
    function prueba(Request $request){
        $palabra = $request->input('palabra');
        try{
            $palabra = Word::findOrFail($palabra);
            return response()->json(['successful'=>true, 'data'=>$palabra], 204);
        }catch(ModelNotFoundException $err){
        return response()->json(['successful'=>false, 'data'=>$palabra], 400);
    }
}
}