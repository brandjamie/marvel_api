<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Marvel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
         html, body {
             background-color: #fff;
             color: #636b6f;
             font-family: 'Nunito', sans-serif;
             font-weight: 200;
             height: 100vh;
             margin: 0;
         }

         .full-height {
             height: 100vh;
         }

         .flex-center {
             align-items: center;
             display: flex;
             justify-content: center;
         }
	 .footer {
	     display:block;
	     width: 100%;
	 }
	 #item_container {
	     width:100%;
	     overflow: hidden;

         }
         .items {
             display: inline;
             float: left;
             text-align: left;
             width: 200px;
         }
	 .main {
             width: 100%
         }
	 #attribution{
             display:block;

         }
         .position-ref {
             position: relative;
         }

         .top-right {
             position: absolute;
             right: 10px;
             top: 18px;
         }

         .content {
             text-align: center;
             margin-left: 10%;
             margin-right: 10%;
             
         }

         .title {
             text-align: center;
             font-size: 84px;
         }


         .links > a {
             color: #636b6f;
             padding: 0 25px;
             font-size: 13px;
             font-weight: 600;
             letter-spacing: .1rem;
             text-decoration: none;
             text-transform: uppercase;
         }

         .m-b-md {
             margin-bottom: 30px;
             padding-top:30px;
         }
	 h2 {
	     text-align:center;
	 }
        </style>
    </head>
    <body>
	<div class="position-ref full-height">
	    
	    @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                    <a href="{{ url('/home') }}">Home</a>
            @else
                    <a href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                    @endauth
                </div>
            @endif
            <div class="content">
                <div class="title m-b-md">
                    @yield('headline')
                </div>
		<div class="innner_content">
		    @yield('inner_content')
		</div>
	    </div>
	<div class="footer">
	    <div class="links">
		
		<a href="/">Search Character</a>
		
	    </div>

	    <div id="attribution">
		@yield('attribution')
	    </div>
	</div>
    </body>
</html>
