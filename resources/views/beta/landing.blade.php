<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
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
	
	<title>Bookie.GG Beta Sign-up</title>

	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700,100,900' rel='stylesheet' type='text/css'>
	<style>
		* { box-sizing: border-box; }
		html { width: 100%; height: 100%; }
		body {
			height: 100%;
			margin: 0;
			padding: 0;
			white-space: nowrap;

			background: #02a4d9;
			color: #fff;
			font-weight: 700;
			font-family: "Roboto", sans-serif;
			text-align: center;
		}
		body::before {
			content:"";
			display: inline-block;
			height: 100%;
			vertical-align: middle;
			margin-right: -.25em;
		}
		.center {
			text-align: left;
			max-width: 500px;
			display: inline-block;
			vertical-align: middle;
			white-space: initial;
		}
		.logo-container { display: table; }
		.logo {
			display: table-cell;
			width: 128px;
		}
		.title-container {
			display: table-cell;
			vertical-align: middle;
		}
		h1 { margin: 0; font-size: 56pt; }
		h2 { margin: 0; font-size: 16pt; }

		p { line-height: 1.5em; }
		.connect {
			margin: 2em 0 0; 
			display: block;
			text-align: center;
		}
		input {
			appearance: none;
			-webkit-appearance: none;
			-moz-appearance: none;

			width: 100%;
			padding: 1em;
			margin-bottom: .5em;

			color: #02a4d9;

			outline: none;
			border: none;
			border-radius: 3px;
		}
		input[type="submit"] {
			cursor: pointer;
			float: right;
			width: auto;
			background: #02a4d9;
			border: 1px solid;
			color: #fff;
			font-weight: 700;

			transition: background .2s;
		}

		.btn {
			display: inline-block;
			width: 32%;
			padding: .5em 1em;
			margin-right: 1%;

			border: 1px solid;
			border-radius: 3px;
			color: #fff;
			text-decoration: none;
			text-align: center;

			transition: background .2s;
		}
		input[type="submit"]:hover, .btn:hover {
			background: #2db7e4;
		}
	</style>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<div class="center">
		<div class="logo-container">
			<img class="logo" src="{{ asset('images/logo_beta.png') }}" />
			<div class="title-container">
				<h1>Bookie.GG</h1>
				<h2 class="subheader">A Revolution for E-Sports Betting</h2>
			</div>
		</div>

		@if(!Auth::check())
			<a href="{{ action('SteamController@login') }}" class="connect">
				<img src="{{ asset('images/steamsignin.png') }}">
			</a>
		@else
			<p>Hi {{ Auth::user()->display_name }}.

			@if(Auth::user()->subscription)
				<p>Congratulations!<br>
				You've signed up for your spot in the Bookie.GG beta.<br>
				You're currently in spot #{{ $user->queue_spot }}, and will receive an e-mail at {{ $user->email }} once it's your turn.</p>
				<p>If you want to learn more about us, or be the first to know when we are released, you can find us on the following sites:</p>
				<div class="btn-container">
					<a class="btn" href="://twitter.com/bookie_gg">Twitter</a><a class="btn" href="://reddit.com/r/bookiegg">Reddit</a><a class="btn" href="://steamcommunity.com/groups/bookiegg">Steam</a>
				</div>
			@else
				<p>Thanks a lot for your interest in Bookie.GG! We're currently in closed beta. If you want to be amongst the first to try us out, you can sign up below.</p>
				<p>There are currently {{ $queue_size }} others in the beta queue.
				</p>
				{!! Form::open(['route' => 'home']) !!}
				{!! Form::text('email', null, array('placeholder' => 'Your Email')) !!}
				{!! Form::text('name', null, array('placeholder' => 'Your Name')) !!}

				{!! Form::submit('Sign Up') !!}
				{!! Form::close() !!}
			@endif
		@endif
	</div>
</body>
</html>

