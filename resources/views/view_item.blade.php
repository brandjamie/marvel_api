@extends('layout')
@section('headline')
    {{ $data->name }}
@endsection

@section('inner_content')

    {!! $data->description !!}
    <br>
    @if ( $data->onsaledate )
	Date of Sale : {{ $data->onsaledate }}
	<br>
    @endif
    @if ( $data->thumbnail )
	@if ($data->thumbnail != ".")
	    <img src='{{ $data->thumbnail }}' width="200px"/>
	@endif
    @endif
    <div id="item_container">
	@if($data->comics)
	    @if( count($data->comics) > 0) 
		<div class="items">
		    <h2>Comics</h2>
		    <ul>
			@foreach ( $data->comics as $comic_item )
			    <li><a href="/comics?id={{ $comic_item->comic()->first()->id }}"> {{ $comic_item->comic()->first()->name}}</a> </li>
			@endforeach
		    </ul>
		</div>
	    @endif
	@endif
	@if( $data->events)
	    @if( count($data->events) > 0) 
   		<div class="items">
		    <h2>Events</h2>
		    <ul>
			@foreach ( $data->events as $event_item )
			    <li><a href="/events?id={{ $event_item->event()->first()->id}}"> {{ $event_item->event()->first()->name}} </a> </li>
			@endforeach
		    </ul>
		</div>
	    @endif
	@endif
	@if( $data->stories)
	    @if( count($data->stories) > 0) 
   		<div class="items">
		    <h2>Stories</h2>
		    <ul>
			@foreach ( $data->stories as $story_item )
			    <li> <a href="/stories?id={{ $story_item->story()->first()->id }}">{{ $story_item->story()->first()->name}} </a></li>
			@endforeach
		    </ul>
		</div>
	    @endif
	@endif
	@if( $data->series)
	    @if( count($data->series) > 0) 
   		<div class="items">
		    <h2>Series</h2>
		    <ul>
			@foreach ( $data->series as $series_item )
			    <li> <a href="/series?id={{ $series_item->series()->first()->id }}" >{{ $series_item->series()->first()->name}} </a></li>
			@endforeach
		    </ul>
		</div>
	    @endif
	@endif
	@if( $data->characters)
	    @if( count($data->characters) > 0) 
		<div class="items">
		    <h2>Characters</h2>
		    <ul>
			@foreach ( $data->characters as $character_item )
			    <li> <a href="/character?id={{ $character_item->character()->first()->id }}" > {{ $character_item->character()->first()->name}} </a> </li>
			@endforeach
		    </ul>
		</div>
	    @endif
	@endif
    </div>
    
    

@endsection

@section('links')
    <a href="/">Search for a Character</a>
@endsection

@section('attribution')
    

    {{ $data->attribution }}


@endsection
