<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getNames(){
        $users = User::all();
        foreach($users as $user){
            echo Capitalize($user->name)."\n";
        }
    }
    public function show(Request $request){
       try{
            $request->validate(['email'=>'required|email',
                                'phone'=>'required|size:10']);
            $emailExists = false;
            $phoneExists = false;
            $users = User::all();
           foreach ($users as $user) {
            if (isset($user['email']) && $user['email'] === $request->input('email')) {
                $emailExists = true;
            }
            if (isset($user['phone']) && $user['phone'] === $request->input('phone')) {
                $phoneExists = true;
            }
            if($emailExists||$phoneExists){
                return response()->json(['message'=>'success'], 200);
            }
        }
    }catch(Exception $e){
        return response()->json(['message'=>'invalid request'
                                 ,'error'=>$e->getMessage()], 404);
    }
    }
    public function Register(Request $request){
        $request->validate([
            'phone'=>'required|size:10',
            'password'=>'required|confirmed'
        ]);
        User::create([
            'phone'=>$request->phone,
            'password'=>Hash::make($request->password)
        ]);
        
        return response()->json('client added successfuly', 201);
    }
    public function Login(Request $request){
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

    public function Logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json('Logout successfully', 200);
    }

    public function destroy($id){
        User::findOrFail($id)->delete();
        return response()->json('User Deleted Successfully', 200);
    }
    public function index(){
        return response()->json(['users'=>User::all()], 200);
    }
    public function trashed(){
        return response()->json(['trashed users'=>User::onlyTrashed()->get()], 200);
    }
    public function forceDelete($id){
        $user = User::onlyTrashed()->findOrFail($id)->forceDelete();
        return response()->json('forceDeleted successfully', 200);
    }
    public function restore($id){
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return response()->json(['massege'=>'restored successfully ','data'=>$user], 200);
    }
    public function getAll(){
        return response()->json(['All users'=>User::withTrashed()->get()], 200);
    }
}
