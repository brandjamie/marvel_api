@extends('layout')
@section('headline')
    {{ $story->name }}
@endsection

@section('inner_content')

    {!! $story->description !!}
<br>
    <img src='{{ $story->thumbnail }}' width="200px"/>

    <div id="item_container">
   	<div class="items">
	    <h2>Comics</h2>
	    <ul>
		@foreach ( $story->comics as $comic_item )
		    <li><a href="comics?id={{ $comic_item->comic()->first()->id }}"> {{ $comic_item->comic()->first()->name}}</a> </li>
		@endforeach
	    </ul>
	</div>
   	<div class="items">
	    <h2>Events</h2>
	    <ul>
		@foreach ( $story->events as $event_item )
		     <li><a href="events?id={{ $event_item->event()->first()->id}}"> {{ $event_item->event()->first()->name}} </a> </li>
		@endforeach
	    </ul>
	</div>
   	<div class="items">
	    <h2>Series</h2>
	    <ul>
		@foreach ( $story->series as $series_item )
		      <li> <a href="series?id={{ $series_item->series()->first()->id }}" >{{ $series_item->series()->first()->name}} </a></li>
		@endforeach
	    </ul>
	</div>
	<div class="items">
	    <h2>Characters</h2>
	    <ul>
		@foreach ( $story->characters as $character_item )
		    <li> <a href="character?id={{ $character_item->character()->first()->id }}" > {{ $character_item->character()->first()->name}} </a> </li>
		@endforeach
	    </ul>
	</div>
    </div>
    
    
    
@endsection



@section('attribution')
    

    {{ $story->attribution }}


@endsection