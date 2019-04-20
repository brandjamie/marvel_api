@extends('layout')
@section('headline')
    {{ $character->name }}
@endsection

@section('inner_content')

    {!! $character->description !!}
    <br>

    <img src='{{ $character->thumbnail }}' width="200px"/>

    <div id="item_container">
	<div class="items">
	    <h2>Comics</h2>
	    <ul>
		@foreach ( $character->comics as $comic_item )
		    <li><a href="comics?id={{ $comic_item->comic()->first()->id }}"> {{ $comic_item->comic()->first()->name}}</a> </li>
		@endforeach
	    </ul>
	</div>
   	<div class="items">
	    <h2>Events</h2>
	    <ul>
		@foreach ( $character->events as $event_item )
		    <li><a href="events?id={{ $event_item->event()->first()->id}}"> {{ $event_item->event()->first()->name}} </a> </li>
		@endforeach
	    </ul>
	</div>
   	<div class="items">
	    <h2>Stories</h2>
	    <ul>
		@foreach ( $character->stories as $story_item )
		    <li> {{ $story_item->story()->first()->name}} </li>
		@endforeach
	    </ul>
	</div>
   	<div class="items">
	    <h2>Series</h2>
	    <ul>
		@foreach ( $character->series as $series_item )
		    <li> <a href="series?id={{ $series_item->series()->first()->id }}" >{{ $series_item->series()->first()->name}} </a></li>
		@endforeach
	    </ul>
	</div>
    </div>
    
    
    
@endsection



@section('attribution')
    

    {{ $character->attribution }}


@endsection
