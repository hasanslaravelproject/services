@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
    
    <div class="row">
    
    @foreach($packages as $package)
    <div class="col-sm-4 form-group p-3" style="border: 1px solid cyan">
    <p class="text-center">{{$package->name}}</p>
    <p class="text-center">{{$package->price}}</p>
    <p class="text-center">{{$package->validity}}</p>
    <a class="btn btn-success text-center" href="{{route('package.checkout',['id'=>$package->id])}}">Choose</a>
    </div>
    @endforeach
    
    </div>
      
    </div>
</div>
@endsection
