<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\{Validator};
use App\Models\User;
use App\Http\Controllers\Api\BaseController;

class UserController extends BaseController
{
    public function login(Request $request){
        $credentials = [
            'email' =>$request->email,
            'password' =>$request ->password
        ];

        if(Auth::attempt($credentials)){

            $user = Auth::user();
            $success['token'] =  $user->createToken('AppName')-> accessToken;
            $success['user'] =  $user->email;

            return $this->sendResponse($success, 'Login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function register(Request $request)
    {
        $dataValidated=$request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        $dataValidated['password']=Hash::make($request->password);

        $user = User::create($dataValidated);

        $token = $user->createToken('AppNAME')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }
    public function index()
    {
        return response()->json(['user' => auth()->user()], 200);
    }

   public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    } 

    public function update(Request $request, $id)
    {
        $user=User::find($id);
        if(auth()->user()->id==$user->id){
            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)]);
                return response()->json(['user' => auth()->user()], 200);
        }
        else{
            return response()->json(['user' => auth()->user()], 401);
        }
        //dd($request);
        
        

          
    }

}
