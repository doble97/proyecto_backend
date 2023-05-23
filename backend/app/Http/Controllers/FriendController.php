<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FriendController extends Controller
{
        //Send Friend Request
        function send(Request $request){
            $id = $request->input('user');
            $UserId = $request->user()->id;
            if($id != $UserId){
            try{
                User::findOrFail($id);
            }catch (ModelNotFoundException $err){
                return response()->json(['success'=>false, 'message'=>'Usuario no encontrado']);
            }
            $UserId = $request->user()->id;
            $friends = new Friend();
            $friends->fk_user_send_request = $UserId;
            $friends->fk_user_receive_request = $id;
            $friends->save();
            return response()->json(['success'=>true, 'message'=>'Solicitud enviada']);
            }
            return response()->json(['success'=>false, 'message'=>'Parametros incorrectos'], 400);
        }

        // Show Friend Request
            public function petition(Request $request){
                $userId = $request->user()->id;
                $info = User::join('friends', 'users.id', '=', 'friends.fk_user_send_request')
                ->where('friends.fk_user_receive_request', $userId)
                ->where('friends.state_request', 3)
                ->select('users.id', 'users.name', 'users.email')
                ->get();
                return response()->json(['success'=>true,'data'=>$info]);
            }

            
            // ACCEPT PETITION
            public function accept_petition(Request $request){
                $friendId = $request->input('user');
                $userId = $request->user()->id;
                try{
                    $friend = Friend::where('fk_user_send_request', $friendId)
                        ->where('fk_user_receive_request', $userId)
                        ->first();
            
                    if($friend){
                        $friend->state_request = 'accepted';
                        $friend->save();
                        return response()->json(['success'=>true,'message'=>'Solicitud aceptada']);
                    } else {
                        return response()->json(['success'=>false, 'message'=>'Registro no encontrado'], 404);
                    }
                } catch(ModelNotFoundException $err){
                    return response()->json(['success'=>false, 'message'=>'Registro no encontrado'], 404);
                }
            }
}
