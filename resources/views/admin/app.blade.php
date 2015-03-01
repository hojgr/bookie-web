<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bookie.GG - Upcoming Matches</title>

	<link href="{{ elixir('css/admin.css') }}" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700,100,900' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	@section('header')
		<div class="header">
			<div class="logo"><div></div></div>
			<div class="nav center">
				<ul>
					<li class="active">Main page</li>
					<li>News</li>
				</ul>
			</div>
		</div>
		<div class="container center"> {{--todo: consider options for this opener--}}
	@show

	@section('leftside')
		<div class="left-side">
			<div class="user-left">
				@if (!Auth::check())
					<div class="steam-button">
						<a href="{{ route('login') }}" class="connect"><img src="{{ asset('images/steamsignin.png') }}"/></a>
					</div>
				@else
					<div class="username-container">
						<div class="avatar">
							<img src="{{ SteamUtil::avatarPathToAvatarURL(Auth::user()->avatar_path) }}" />
						</div>
						<div class="username">{{ Auth::user()->display_name }}</div>
					</div>
					<ul>
						<li><a href="{{ route('logout') }}">Logout</a></li>
					</ul>
				@endif
			</div>
		</div>
	@show

	<div class="content">
		@yield('content')
	</div>

	<div class="rightside">
		@section('rightside')
			<div class="right-side">
				rightie admin
			</div>
		@show
	</div>

	</div> {{--todo: remember that weird opener earlier?--}}

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

	<script src="http://localhost:8000/js/live.js"></script>
</body>
</html>