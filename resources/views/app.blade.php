<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="/favicon/favicon-32x32.png?v=3" sizes="32x32">
	<link rel="icon" type="image/png" href="/favicon/favicon-96x96.png?v=3" sizes="96x96">
	<link rel="icon" type="image/png" href="/favicon/favicon-16x16.png?v=3" sizes="16x16">
	<link rel="manifest" href="/favicon/manifest.json">
	
	<title>Bookie.GG</title>
	<link href="/css/beta-20150323.css" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700,100,900' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	@if(Session::has('message'))
		@foreach(Session::get('message') as $m)
			<div class="notice notice-{{ $m['type'] }}">
				{!! $m['message'] !!}
			</div>
		@endforeach
	@endif
	@section('header')
	<div class="header">
		<a class="logo" href="{{ route('home') }}"><img src="{{ asset('images/header.png') }}"></a>
		
		<ul class="nav">
			<li class="item @if(Request::is('/'))active @endif">
				<a href="{{ route('home') }}">Matches</a>
			</li>
			<li class="item @if(Request::is('rules'))active @endif">
				<a href="{{ route('rules') }}">Rules</a>
			</li>
			<li class="item @if(Request::is('tos'))active @endif">
				<a href="{{ route('tos') }}">Terms of Service</a>
			</li>
			<li class="item @if(Request::is('contact'))active @endif">
				<a href="{{ route('contact') }}">Contact Us</a>
			</li>
			<li class="item @if(Request::is('partners'))active @endif">
				<a href="{{ route('partners') }}">Partners</a>
			</li>
			<li class="item"><a href="http://reddit.com/r/bookiegg" target="_blank">Reddit</a></li>

			<div id="nav-indicator"></div>
		</ul>
	</div>
	@show

	<div class="page">
		@section('misc-column')
		<div class="column misc-column">
			<div class="module user-module">
				<div class="center-wrap">
					@if (!Auth::check())
					<a class="steam-button" href="{{ route('login') }}">
						<img alt="Steam sign-in" src="{{ asset('images/steamsignin.png') }}"/>
					</a>
					@else
					<div class="username-container">
						<div class="avatar">
							<img src="{{ SteamUtil::avatarPathToAvatarURL(Auth::user()->avatar_path) }}" />
						</div>
						<h2>{{ Auth::user()->display_name }}</h2>
					</div>
					<ul>
						@if(Auth::check() and Auth::user()->admin == "1")
							<li><a href="{{ route('admin_home') }}">Administration</a></li>
						@endif
						<li><a href="{{ route('logout') }}">Logout</a></li>
					</ul>
					@endif
				</div>
			</div>
			<div class="module tweet-module">
				<a class="twitter-timeline" data-tweet-limit="1" data-chrome="nofooter" href="https://twitter.com/Bookie_GG" data-widget-id="571912429093662720">Tweets by @Bookie_GG</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div>
			<div class="module news-module">
				<h3>News</h3>
				<ul>
					@foreach($articles as $a)
						<li><a href="{{ route('article', $a->id) }}">{{ str_limit($a->title, 32) }}</a></li>
					@endforeach
				</ul>
			</div>
		</div>
		@show

		@yield('content')
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="{{ asset('libs/simplyscroll/jquery.simplyscroll.min.js') }}"></script>
	<!--<script src="http://localhost:8000/js/live.js"></script>-->
	<script src="{{ asset('js/common.js') }}"></script>
</body>
</html>
