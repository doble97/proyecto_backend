namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login(LoginRequest $request){

        $token = $request->user()->createToken('MyApp')->plainTextToken;
        return response()->json([
            'success'=>true,
            'message'=>'Correct login',
            'data'=>['token'=>$token, 'user'=>$request->user()],],200);
    }

    public function register(RegisterRequest $request){
        $user = new User();
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        // $token = $user->createToken('MyApp')->plainTextToken(7400); //dos horas
        $token = $user->createToken('kario')->plainTextToken;
        return response()->json(['success'=>true,'message'=>'User created', 'data'=>['token'=>$token]],201);

    }
<<<<<<< HEAD
}
=======
}
>>>>>>> alexis
