<?php

namespace App\Http\Controllers;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FriendController extends Controller
{

        // Search Friend
        public function searchFriend(Request $request){
            $email = $request->input('email');
            try{
                $usuario = User::where('email', $email)->firstOrFail();
                return response()->json(['success'=>true, 'message'=>'Usuario encontrado', 'data'=>$usuario],200);
            }catch(ModelNotFoundException $err){
                return response()->json(['success'=>false,'message'=>'Usuario no encontrado'], 404);
            }
        }

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
            $info = "SELECT state_request FROM friends WHERE fk_user_send_request = ? AND fk_user_receive_request = ?";
            $bloq = DB::select($info, [$id,$UserId]);
            if($bloq){
                return response()->json(['success'=>false, 'message'=>'Ya tienes una peticion de amistad de este usuario']);
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

            
            // Accept Petition
            public function accept_petition(Request $request){
                $friendId = $request->input('user');
                $userId = $request->user()->id;
                $accept_petition = "UPDATE friends SET state_request = 'accepted' WHERE fk_user_send_request = ? AND fk_user_receive_request = ? AND state_request = 'pending'";
                $comp = DB::update($accept_petition, [$friendId, $userId]);
                if($comp){
                return response()->json(['success' => true, 'message' => 'Solicitud aceptada']);
                } else {
                return response()->json(['success'=>false, 'message'=>'Parametros incorrectos'], 400);
            }
        }

            // Deny Petition
            public function deny_petition(Request $request){
                $friendId = $request->input('user');
                $userId = $request->user()->id;
                $accept_petition = "UPDATE friends SET state_request = 'denied' WHERE fk_user_send_request = ? AND fk_user_receive_request = ? AND state_request = 'pending'";
                $comp = DB::update($accept_petition, [$friendId, $userId]);
                if($comp){
                    return response()->json(['success' => true, 'message' => 'Solicitud rechazada']);
                } else {
                    return response()->json(['success'=>false, 'message'=>'Parametros incorrectos'], 400);
                    }
                }

            // Show Friends
            public function friend(Request $request){
                $userId = $request->user()->id;
                $info_1 = User::join('friends', 'users.id', '=', 'friends.fk_user_receive_request')
                ->where('friends.fk_user_send_request', $userId)
                ->where('friends.state_request', 2)
                ->select('users.id', 'users.name', 'users.email')
                ->get();
                $info_2 = User::join('friends', 'users.id', '=', 'friends.fk_user_send_request')
                ->where('friends.fk_user_receive_request', $userId)
                ->where('friends.state_request', 2)
                ->select('users.id', 'users.name', 'users.email')
                ->get();
                $friends = $info_1->merge($info_2);
                return response()->json(['success'=>true,'data'=>$friends]);
            }
}