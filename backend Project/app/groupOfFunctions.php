<?php

namespace App;

use App\Http\Requests\ReserveRequest;
use App\Models\Apartment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait groupOfFunctions
{
 public function login(Request $request){
      $request->validate([
            'phone'=>'required',
            'password'=>'required'
        ]);
        if(!Auth::attempt($request->all()))
            return response()->json('invaled phone or password', 403);
       $user = User::where('phone',$request->phone)->firstOrFail();
       $token = $user->createToken('auth_token')->plainTextToken;
       return response()->json(['login successfully','user'=>$user,'token'=>$token], 200);
    
 }
  public function sign_up(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json('Logout successfully', 200);
    }
    public function showAllApartments(){
        return Apartment::all();
    }

}
