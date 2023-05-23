<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    //
    public function searchFriend(Request $request){
        $email = $request->input('email');
        try{
            $usuario = User::where('email', $email)->firstOrFail();
            return response()->json(['success'=>true, 'message'=>'Usuario encontrado', 'data'=>$usuario],200);
        }catch(ModelNotFoundException $err){
            return response()->json(['success'=>false,'message'=>'Usuario no encontrado'], 404);
        }
    }
}
