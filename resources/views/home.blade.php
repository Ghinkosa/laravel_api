@extends('layouts.app')

@section('content')
<html>
    <head>
    <style>
        .galata {
            height:50%;
            overflow: hidden;
        }
        .galata:hover{
            overflow-y: scroll;
        }
        .size{
            font-size:20px;
        }
        .long{
            height:84%;
            overflow: hidden;
        }
        .long:hover{
            overflow-y: scroll;
        }
        .margin-le{
            margin-left:55%;
        }
        .callme{
         
            border-bottom-right-radius:20px;
            padding-left:5px;
        }
        .callmeto{
        padding-left:5px;
         border-bottom-left-radius:20px;
     }
</style>
    </head>
</html>
<div class="d-flex flex-row">
    <div class="ml-3 col-md-4">
        <div>
            <div class="card bg-light">
                <div class="card-header bg-light" system><input class=" form-control-lg" type="text" placeholder="search"><button type="button" class="btn btn-outline-success btn-lg mx-2">search</button></div>

                <div class="card-body galata rounded">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <nav class="nav flex-column justify-content-center">
                      @foreach($data as $value)
                      @if($value->id==Auth::user()->id)
                      @else
                      <a class="nav-link btn btn-success text-light my-1 py-3" href="display/{{$value->id}}"><div class="size">{{$value->name}}</div><div>Microsoft and our third-party vendors use cookies to s</div>  
                      </a>
                      @endif
                      @endforeach
                    </nav>
                </div>
            </div>
        </div>
    </div>
      <div class="col-md-8 bg-secondary">
        <div class="long mt-2">
            @if(Session::get('stat'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{Session::get('stat')}}
            </div>
            @endif
            <h1>Select user frist</h1>    
        </div>
       <form action="/notsent" method="POST">
       @csrf
         <div class="form-group">
         <input type="hidden" value="2" name="id">
         <input type="hidden" value="{{ Auth::user()->id }}" name="userid">
      </div>
         <div class="form-group d-flex flex-row ">
         <textarea class="form-control" rows="2" placeholder="write message here" name="texts"></textarea>
         <button type="submit" class="btn btn-primary btn-lg mx-3 px-3">send</button>

    </div>
      </form>
    <div>
</div>
@endsection
