<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $data=User::all();
        return view('home',compact('data'));
    }
    public function name()
    {   
        return view('name');
    }
    public function display($id)
    {
        $sele=$id;
        $data=User::all();
        $message1=DB::select('select * from chats where (id1=:id1 && id2=:id2) || (id1=:id3 && id2=:id4)',["id1"=>Auth::id(),"id2"=>$id,"id4"=>Auth::id(),"id3"=>$id]);

        $total=$message1;

        
        return view('body',compact('data','sele','total'));
    }
    public function send(Request $req)
    {
        $message=new Chat;
        $message->id1=Auth::id();
        $message->id2=$req->id;
        $message->chats=$req->texts;
        $message->viewed="false";
        $message->save();
        return redirect()->back();
    }
    public function notsent(Request $req){
          $req->session()->flash('stat','you have to choose the user frist to send a message');
          return redirect('home');
    }
}
