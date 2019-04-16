@extends('layout')
@section('headline')
    {{ $json['data']['results'][0]['name'] }}
@endsection

@section('inner_content')

    {{ $json['data']['results'][0]['description'] }}
    <br>

    <img src='{{ $json['data']['results'][0]['thumbnail']['path'] }}.{{ $json['data']['results'][0]['thumbnail']['extension'] }}' width="200px"/>

    
    <div id="item_container">
	<div class="items">
	    <h2>Comics</h2>
	    <ul>
		@foreach ( $json['data']['results'][0]['comics']['items'] as $item )
		    <li> {{ $item['name'] }} </li>
		@endforeach
	    </ul>
	</div>
	<div class="items">
	    <h2>Events</h2>
	    <ul>
		@foreach ( $json['data']['results'][0]['events']['items'] as $item )
		    <li> {{ $item['name'] }} </li>
		@endforeach
	    </ul>
	</div>
	<div class="items">
	    <h2>Stories</h2>
	    <ul>
		@foreach ( $json['data']['results'][0]['stories']['items'] as $item )
		    <li> {{ $item['name'] }} </li>
		@endforeach
	    </ul>
	</div>
	<div class="items">
	    <h2>Series</h2>
	    <ul>
		@foreach ( $json['data']['results'][0]['series']['items'] as $item )
		    <li> {{ $item['name'] }} </li>
		@endforeach
	    </ul>
	</div>

    </div>


    
@endsection



@section('attribution')
    

    {{ $json['attributionText'] }}



@endsection
