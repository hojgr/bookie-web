{{-- */ if (!isset($wideLayout)) $wideLayout = false; /*--}}

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
	<link href="/css/libs.css" rel="stylesheet" type="text/css">
	<link href="/css/compiled.css" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700,100,900' rel='stylesheet' type='text/css'>
	@yield('css')

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script src="{{ asset('js/libs.js') }}"></script>
	<script src="{{ asset('js/compiled.js') }}"></script>
</head>
<body>
	<div id="progress-bar"></div>
	<div id="body">
	@section('header')
	<div class="header">
		<a class="logo" href="{{ route('home') }}"><img src="{{ asset('images/header.png') }}"></a>
		
		{{-- */ $header_links = ['home' => 'Matches', 'bank' => 'Bank', 'rules' => 'Rules', 'help' => 'Help', 'partners' => 'Partners']; /*--}}		
		{{-- */ $help_links = ['help' => 'Getting started', 'contact' => 'Contact us'] /* --}}
		{{-- */ $cur_route = Route::currentRouteName() /* --}}
		<ul class="nav hide-xs">
			@foreach ($header_links as $l=>$s)
				@if ($l=='help')
				<li class="item dropdown{{ array_key_exists($cur_route, $help_links) ? ' active' : '' }}">
					<span>{{ $s }}</span>
					<div class="content">
						<ul class="flex-column no-padding no-margin">
						@foreach ($help_links as $l=>$s)
							<li class="item">
								<a class="noblue" href="{{ route($l) }}">{{ $s }}</a>
							</li>
						@endforeach
						</ul>
					</div>
				</li>
				@else
				<li class="item{{ $l==$cur_route ? ' active' : '' }}">
					<a class="noblue" href="{{ route($l) }}">{{ $s }}</a>
				</li>
				@endif
			@endforeach
			{{-- <li class="item"><a class="noblue" href="http://reddit.com/r/bookiegg" target="_blank">Reddit</a></li> --}}

			<div id="nav-indicator"></div>
		</ul>
		<ul class="mobile-nav visible-xs">
			<li class="item"><span>Menu</span></li>
			@foreach ($header_links as $l=>$s)
				@if ($l=='help')
					@foreach ($help_links as $l=>$s)
						<li class="item{{ $l==$cur_route ? ' active' : '' }}">
							<a class="noblue" href="{{ route($l) }}">{{ $s }}</a>
						</li>
					@endforeach
				@else
				<li class="item{{ $l==$cur_route ? ' active' : '' }}">
					<a class="noblue" href="{{ route($l) }}">{{ $s }}</a>
				</li>
				@endif
			@endforeach
			
			{{-- <li class="item"><a class="noblue" href="http://reddit.com/r/bookiegg" target="_blank">Reddit</a></li> --}}
		</ul>
	</div>
	@show

	@if(Session::has('message'))
		<div class="message-container">
		@foreach(Session::get('message') as $m)
			<div class="message message-{{ $m['type'] }}">
				{!! $m['message'] !!}
			</div>
		@endforeach
		</div>
	@endif

	<div class="page fadein @if($wideLayout)wide @endif">
		@section('misc-column')
		<div class="column small misc-column">
			<div class="module user-module">
				<h2>{{ Auth::check() ? "Profile" : "Login" }}</h2>
				<div class="flex-column flex-center">
					@if (!Auth::check())
					<a class="steam-button no-smoothstate" href="{{ route('login') }}">
						<img alt="Steam sign-in" src="{{ asset('images/steamsignin.png') }}"/>
					</a>
					@else
					<a href="/profile/me" class="flex-column flex-center">
						<img class="user-avatar" src="{{ SteamUtil::avatarPathToAvatarURL(Auth::user()->avatar_path) }}" />
						<h3 class="user-name">{{ Auth::user()->display_name }}</h3>
					</a>
					<ul class="user-navigation flex-wrap no-padding">
						@if(Auth::check() and Auth::user()->admin == "1")
							<li class="btn btn-wide"><a class="noblue no-smoothstate" href="{{ route('admin_home') }}">Administration</a></li>
						@endif
						<li class="btn btn-wide"><a class="noblue no-smoothstate" href="{{ route('logout') }}">Logout</a></li>
					</ul>
					@endif
				</div>
			</div>
			<div class="module tweet-module flex-center flex-fill">
				<a class="twitter-timeline" data-tweet-limit="1" data-chrome="nofooter" href="https://twitter.com/Bookie_GG" data-widget-id="571912429093662720">Tweets by @Bookie_GG</a>
				<script>function loadTwitter(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}};loadTwitter(document,"script","twitter-wjs")</script>
			</div>
			<div class="module news-module">
				<h2>News</h2>
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
	</div>
</body>
</html>
