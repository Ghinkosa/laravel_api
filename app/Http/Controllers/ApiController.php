<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function register(Request $req){
          $req->validate([
              'name'=>'required',
              'email'=>'required|email|unique:users',
              'password'=>'required|confirmed'
          ]);

           User::create([
            'name' => $req['name'],
            'email' => $req['email'],
            'password' => Hash::make($req['password']),
        ]);
        return "added successfully";
    }
    public function login(Request $req){
        $credentials=$req->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if(Auth::attempt($credentials)){
             $user=Auth::user();
             $token=$user->createToken('forever')->plainTextToken;
             return response()->json([
                'user'=>$user,
                'token'=>$token,
                'message'=>"success"
             ]);
        }
        return response()->json([
            'message'=>"wrong password or email"
        ]);
    }
    public function index(){
        $data=User::all()->except(Auth::id());
        return response()->json([
            'data'=>$data
         ]);
    }
    public function current(Request $req){
          $user=Auth::user();
          return response()->json([
            'user'=>$user
          ]);
    } public function logout(Request $req){
       auth()->user()->tokens()->delete();
        
        return response()->json([
            'message'=>'success'
         ]);
    }
}
