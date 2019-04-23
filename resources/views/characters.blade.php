@extends('layout')
@section('headline')
    Marvel Characters
@endsection

@section('inner_content')
    @if ($not_found)
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
	    @foreach ($data['data']['results'] as $result)
		<li class="examples">
		    <a href="/characters/{{ $result['name'] }}">
			{{ $result['name'] }}		    
		    </a>
		</li>
	    @endforeach
	</ul>
	<br>
	<br>
	<div class="links">
	    @if (Request()->page)
		<a href ="characters?page={{ Request()->page - 1 }}">Previous Page</a>
		<a href ="characters?page={{ Request()->page + 1 }}">Next Page</a>
	    @else
		<a href ="characters?page=1">Next Page</a>
    @endif
    </div>
</div>

@endsection

@section('attribution')
    {{ $data['attributionText'] }}   
@endsection