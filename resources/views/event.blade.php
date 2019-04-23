@extends('layout')
@section('headline')
    {{ $event->name }}
@endsection

@section('inner_content')

    {!! $event->description !!}
<br>
    <img src='{{ $event->thumbnail }}' width="200px"/>

    <div id="item_container">
   	<div class="items">
	    <h2>Comics</h2>
	    <ul>
		@foreach ( $event->comics as $comic_item )
		   	    <li><a href="comics?id={{ $comic_item->comic()->first()->id}}"> {{ $comic_item->comic()->first()->name}} </a> </li>
		@endforeach
	    </ul>
	</div>
   	<div class="items">
	    <h2>Stories</h2>
	    <ul>
		@foreach ( $event->stories as $story_item )
		    <li> {{ $story_item->story()->first()->name}} </li>
		@endforeach
	    </ul>
	</div>
   	<div class="items">
	    <h2>Series</h2>
	    <ul>
		@foreach ( $event->series as $series_item )
		    <li> {{ $series_item->series()->first()->name}} </li>
		@endforeach
	    </ul>
	</div>
	<div class="items">
	    <h2>Characters</h2>
	    <ul>
		@foreach ( $event->characters as $character_item )
		    <li> <a href="character?id={{ $character_item->character()->first()->id }}" > {{ $character_item->character()->first()->name}} </a> </li>
		@endforeach
	    </ul>
	</div>
    </div>
    
    
    
@endsection



@section('attribution')
    

    {{ $event->attribution }}


@endsection
