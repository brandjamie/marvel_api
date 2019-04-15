@extends('layout')
    @section('headline')
{{ $json['data']['results'][0]['name'] }}
    @endsection
    
    @section('inner_content')
   {{ $json['data']['results'][0]['description'] }}
<br>
<img src='{{ $json['data']['results'][0]['thumbnail']['path'] }}.{{ $json['data']['results'][0]['thumbnail']['extension'] }}' width="200px"/>

@endsection

    @section('attribution')
{{ $json['attributionText'] }}
    @endsection
