<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Chat;
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
        $mess;
        $data=User::all()->except(Auth::id());
        foreach($data as $me){
            $id=$me->id;
            $mess=Chat::latest()->first();
        }
        return response()->json([
            'data'=>$data,
            'mess'=>$mess
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


    public function messages(Request $req)
    {
        $id=$req->id;
        //$data=DB::select('select * from chats where (id1=:id1 && id2=:id2)',["id1"=>Auth::id(),"id2"=>$id]);
        $data=DB::select('select * from chats where (id1=:id1 && id2=:id2) || (id1=:id3 && id2=:id4)',["id1"=>Auth::id(),"id2"=>$id,"id4"=>Auth::id(),"id3"=>$id]);
       // $b = DB::table('chats')->where(['id1'=>$id])->orderBy('id', 'desc')->first();
        return response()->json([
            'message'=>$data,
         ]);
    }
    public function send(Request $req)
    {
        $message=new Chat;
        $message->id1=Auth::id();
        $message->id2=$req->id2;
        $message->chats=$req->chats;
        $message->viewed="false";
        $message->save();
        return "success";
    }
}
