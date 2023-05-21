<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Deck;
use App\Models\DeckOwner;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login(loginRequest $request){
        $userId= $request->user()->id;
        $token = $request->user()->createToken('MyApp')->plainTextToken;
        $pendind_requests = Friend::where('fk_user_receive_request', $userId)->count();
        $decks = DeckOwner::where('fk_user', $userId)->count();
        $shared_decks=0;
        $followed_decks=0;
        $friends = Friend::where(function($query) use($userId){
            $query->where('fk_user_receive_request', $userId)
            ->orWhere('fk_user_send_request', $userId);
        })
        // ->where('status','pending')
        ->count();
        return response()->json([
            'success'=>true,
            'message'=>'Correct login',
            'data'=>[
                'token'=>$token, 
                'user'=>$request->user(),
                "friends"=>$friends, 
                "pending_requests"=>$pendind_requests,
                "decks"=>$decks,
                "shared_decks"=>$shared_decks,
                "followed_decks"=>$followed_decks
            ],],200);
    }

    public function register(registerRequest $request){
        $user = new User();
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        // $token = $user->createToken('MyApp')->plainTextToken(7400); //dos horas
        $token = $user->createToken('kario')->plainTextToken;
        return response()->json(['success'=>true,'message'=>'User created', 'data'=>[
            'token'=>$token,
            'user'=>$user,
            "friends"=>0, 
            "pending_requests"=>0,
            "decks"=>0,
            "shared_decks"=>0,
            "followed_decks"=>0
            ]],201);

    }
}
