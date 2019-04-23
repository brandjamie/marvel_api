@extends('layout')
@section('headline')
    Marvel Characters
@endsection

@section('inner_content')
    @if (isset($not_found))
	<br>
	Sorry: {{$not_found}} was not found.
	<br>
    @endif
    <div class="search">
	<form method="POST" action='/characters'>
	    {{ csrf_field() }}                            
	    <div>
		Search for a character:
		<br>
		<input type="text" name="name" placeholder="Spider-Man">
		
	    </div>
	    <div>
		<button type="submit">Get info</button>
            </div>
	</form>
	
    </div>
    <div id="examples_container">
	<ul>
	    @foreach ($data->characters as $character)
		<li class="examples">
		    <a href="/characters/{{ $character->name }}">
			{{ $character->name }}		    
		    </a>
		</li>
	    @endforeach
	</ul>
	<br>
	<br>
    </div>

@endsection

@section('links')
	@if (Request()->page)
	    <a href ="characters?page={{ Request()->page - 1 }}">Previous Page</a>
	    <a href ="characters?page={{ Request()->page + 1 }}">Next Page</a>
	@else
	    <a href ="characters?page=1">Next Page</a>
	@endif
@endsection

@section('attribution')
    {{ $data['attributionText'] }}   
@endsection
