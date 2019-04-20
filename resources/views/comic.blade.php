@extends('layout')
@section('headline')
    {{ $comic->name }}
@endsection

@section('inner_content')

    {{ $comic->description }}

    <br>
Date of Sale : {{ $comic->onsaledate }}
<br>
    <img src='{{ $comic->thumbnail }}' width="200px"/>

    <div id="item_container">
   	<div class="items">
	    <h2>Events</h2>
	    <ul>
		@foreach ( $comic->events as $event_item )
		    <li> {{ $event_item->event()->first()->name}} </li>
		@endforeach
	    </ul>
	</div>
   	<div class="items">
	    <h2>Stories</h2>
	    <ul>
		@foreach ( $comic->stories as $story_item )
		    <li> {{ $story_item->story()->first()->name}} </li>
		@endforeach
	    </ul>
	</div>
   	<div class="items">
	    <h2>Series</h2>
	    <ul>
		@foreach ( $comic->series as $series_item )
		    <li> {{ $series_item->series()->first()->name}} </li>
		@endforeach
	    </ul>
	</div>
	<div class="items">
	    <h2>Characters</h2>
	    <ul>
		@foreach ( $comic->characters as $character_item )
		    <li> <a href="character?id={{ $character_item->character()->first()->id }}" > {{ $character_item->character()->first()->name}} </a> </li>
		@endforeach
	    </ul>
	</div>
    </div>
    
    
    
@endsection



@section('attribution')
    

    {{ $comic->attribution }}


@endsection
