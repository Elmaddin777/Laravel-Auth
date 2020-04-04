@extends('layouts.master')
@section('content')
    
    <body style="height:1000px;" class="bg-dark">
      <div class="w-75 mx-auto text-center" style="margin-top:250px;">
        <h1>Dashboard</h1>
        <a href="{{ route('logout') }}">Log out</a>
      </div>
    
@endsection