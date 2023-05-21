<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CountDeckController extends Controller
{
    // Count ALL decks
    public function countAll(Request $request){
        $decks= $request->user()->decks->count();
        return response()->json(['success'=>true, 'data'=>$decks]);
    }

    public function countShared(Request $request){
        $decks= $request->user()->decks->where("shared","1")->count();
        return response()->json(['success'=>true, 'data'=>$decks]);
    }

    public function countCollaborator(Request $request){
        $decks= $request->user()->deck_collaborators->count();
        return response()->json(['success'=>true, 'data'=>$decks]);
    }
}