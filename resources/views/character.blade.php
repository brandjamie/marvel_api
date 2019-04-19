@extends('layout')
@section('headline')
    {{ $character->name }}
@endsection

@section('inner_content')

    {{ $character->description }}
    <br>

    <img src='{{ $character->thumbnail }}' width="200px"/>

    
    
@endsection



@section('attribution')
    

    {{ $character->attribution }}



@endsection
