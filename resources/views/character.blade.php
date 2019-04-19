@extends('layout')
@section('headline')
    {{ $character->name }}
@endsection

@section('inner_content')

    {{ $character->description }}
    <br>

    <img src='{{ $character->thumbnail }}' width="200px"/>

   <div id="item_container">
	<div class="items">
	    <h2>Comics</h2>
	    <ul>
		@foreach ( $character->comics as $comic_item )
		    <li> {{ $comic_item->comic()->first()->name}} </li>
		@endforeach
	    </ul>
	</div>
<div>
    
    
@endsection



@section('attribution')
    

    {{ $character->attribution }}


@endsection
