@extends('layout')
@section('headline')
    {{ $series->name }}
@endsection

@section('inner_content')

    {!! $series->description !!}
<br>
    <img src='{{ $series->thumbnail }}' width="200px"/>

    <div id="item_container">
   	<div class="items">
	    <h2>Comics</h2>
	    <ul>
		@foreach ( $series->comics as $comic_item )
		 	    <li><a href="comics?id={{ $comic_item->comic()->first()->id }}"> {{ $comic_item->comic()->first()->name}}</a> </li>
		@endforeach
	    </ul>
	</div>
   	<div class="items">
	    <h2>Stories</h2>
	    <ul>
		@foreach ( $series->stories as $story_item )
	    <li> <a href="stories?id={{ $story_item->story()->first()->id }}">{{ $story_item->story()->first()->name}} </a></li>
		@endforeach
	    </ul>
	</div>
   	<div class="items">
	    <h2>Event</h2>
	    <ul>
		@foreach ( $series->events as $event_item )
		   	    <li><a href="events?id={{ $event_item->event()->first()->id}}"> {{ $event_item->event()->first()->name}} </a> </li>
		@endforeach
	    </ul>
	</div>
	<div class="items">
	    <h2>Characters</h2>
	    <ul>
		@foreach ( $series->characters as $character_item )
		    <li> <a href="character?id={{ $character_item->character()->first()->id }}" > {{ $character_item->character()->first()->name}} </a> </li>
		@endforeach
	    </ul>
	</div>
    </div>
    
    
    
@endsection



@section('attribution')
    

    {{ $series->attribution }}


@endsection
