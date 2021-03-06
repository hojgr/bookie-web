{{-- */ if (!isset($wideLayout)) $wideLayout = false; /*--}}

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Bookie.GG</title>
	<link href="/css/libs.css" rel="stylesheet" type="text/css">
	<link href="/css/compiled.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
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
			@spaceless
			@foreach ($header_links as $l=>$s)
				@if ($l=='help')
				<li class="item dropdown{{ array_key_exists($cur_route, $help_links) ? ' active' : '' }}">
					<span>{{ $s }}</span>
					<div class="content">
						<ul class="no-padding no-margin">
						@foreach ($help_links as $l=>$s)
							<li class="item">
								<a class="no-style" href="{{ route($l) }}">{{ $s }}</a>
							</li>
						@endforeach
						</ul>
					</div>
				</li>
				@else
				<li class="item{{ $l==$cur_route ? ' active' : '' }}">
					<a class="no-style" href="{{ route($l) }}">{{ $s }}</a>
				</li>
				@endif
			@endforeach
			{{-- <li class="item"><a class="no-style" href="http://reddit.com/r/bookiegg" target="_blank">Reddit</a></li> --}}
			@endspaceless
			<div id="nav-indicator"></div>
		</ul><!--
		--><ul class="mobile-nav visible-xs">
			<li class="item"><span>Menu</span></li>
			@foreach ($header_links as $l=>$s)
				@if ($l=='help')
					@foreach ($help_links as $l=>$s)
						<li class="item{{ $l==$cur_route ? ' active' : '' }}">
							<a class="no-style" href="{{ route($l) }}">{{ $s }}</a>
						</li>
					@endforeach
				@else
				<li class="item{{ $l==$cur_route ? ' active' : '' }}">
					<a class="no-style" href="{{ route($l) }}">{{ $s }}</a>
				</li>
				@endif
			@endforeach
			
			{{-- <li class="item"><a class="no-style" href="http://reddit.com/r/bookiegg" target="_blank">Reddit</a></li> --}}
		</ul>
	</div>
	@show

	<div class="page fadein @if($wideLayout)wide @endif">
		@section('misc-column')
		<div class="column small misc-column">
			@spaceless
			<div class="module user-module">
				<h2>{{ Auth::check() ? "Profile" : "Login" }}</h2>
				<div class="text-center">
					@if (!Auth::check())
					<a class="steam-button no-smoothstate" href="{{ route('login') }}">
						<img alt="Steam sign-in" src="{{ asset('images/steamsignin.png') }}"/>
					</a>
					@else
					<a href="/profile/me">
						<img class="user-avatar" src="{{ SteamUtil::avatarPathToAvatarURL(Auth::user()->avatar_path) }}" />
						<h3 class="user-name">{{ Auth::user()->display_name }}</h3>
					</a>
					<ul class="user-navigation no-padding">
						@if(Auth::check() and Auth::user()->admin == "1")
							<li class="btn btn-wide"><a class="no-style no-smoothstate" href="{{ route('admin_home') }}">Administration</a></li>
						@endif
						<li class="btn btn-wide"><a class="no-style no-smoothstate" href="{{ route('logout') }}">Logout</a></li>
					</ul>
					@endif
				</div>
			</div>
			<div class="module tweet-module text-center">
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
			@endspaceless
		</div>
		@show

		@yield('content')
	</div>
	
	<div class="loader hidden"></div>
	</div>

	@if($isPopupActive)
	<script type="text/javascript">
		new BookieUI.popup('{{ csrf_token() }}');
	</script>
	@endif
</body>
</html>
