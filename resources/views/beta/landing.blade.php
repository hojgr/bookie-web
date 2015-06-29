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
		.logo-container {
			width: 300px;
			margin: 0 auto;
			padding-bottom: 20px;
		}
		.logo {
			width: 300px;
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
			width: 31%;
			padding: .5em 1em;
			margin-right: 1%;

			border: 1px solid;
			border-radius: 3px;
			color: #fff;
			text-decoration: none;
			text-align: center;

			transition: background .2s;
		}

		.btn-logout {
			float: right;
		}

		.activate-input {
			width: 80%;
		}

		.activate-submit {
			padding: 12px;
		}

		input[type="submit"]:hover, .btn:hover {
			background: #2db7e4;
		}

		#invalid_code {
			color: rgb(255, 156, 160);
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
			<img class="logo" src="{{ asset('images/header.png') }}" />
		</div>

		@if(!Auth::check())
			<a href="{{ action('SteamController@login') }}" class="connect">
				<img src="{{ asset('images/steamsignin.png') }}">
			</a>
		@else
			<p>Hi {{ Auth::user()->display_name }}. <a class="btn btn-logout" href="{{ route('logout') }}">Logout</a>

			@if(Auth::user()->subscription)
				<p>Congratulations!<br>
				You've signed up for your spot in the Bookie.GG beta.<br>
				You will receive an e-mail at {{ Auth::user()->subscription->email }} once closed beta becomes available.</p>
				<p>When you receive your code, fill field below.</p>
				@if(Session::get('error', false))
					<span id="invalid_code">Invalid code!</span>
				@endif
				{!! Form::open(['route' => 'beta.activate']) !!}
				{!! Form::text('code', null, array('placeholder' => 'Activation code', 'class' => 'activate-input')) !!}

				{!! Form::submit('Activate!', ['class' => 'activate-submit']) !!}
				{!! Form::close() !!}

				<p>If you want to learn more about us, or be the first to know when we are released, you can find us on the following sites:</p>
				<div class="btn-container">
					<a class="btn" target="_blank" href="//twitter.com/bookie_gg">Twitter</a>
					<a class="btn" target="_blank" href="//reddit.com/r/bookiegg">Reddit</a>
					<a class="btn" target="_blank" href="//steamcommunity.com/groups/bookiegg">Steam</a>
				</div>
			@else
				<p>Thanks a lot for your interest in Bookie.GG! We're currently in closed beta. If you want to be amongst the first to try us out, you can sign up below.</p>
				{!! Form::open(['route' => 'beta.subscribe']) !!}
				{!! Form::text('email', null, array('placeholder' => 'Your Email')) !!}
				{!! Form::text('name', null, array('placeholder' => 'Your Name')) !!}

				{!! Form::submit('Sign Up') !!}
				{!! Form::close() !!}
			@endif
		@endif
	</div>
	<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
	<script>
		$(document).ready(function() {
			var s = $('#invalid_code');
			s.animate({'margin-left': "20px"}, 100, function() {
				s.animate({'margin-left': "-20px"}, 100, function() {
					s.animate({'margin-left': "10px"}, 150, function() {
						s.animate({'margin-left': "-10px"}, 150, function() {
							s.animate({'margin-left': "5px"}, 200, function() {
								s.animate({'margin-left': "-5px"}, 200, function() {
									s.animate({'margin-left': "0px"}, 300);
								});
							});
						});
					});
				});
			});
		});
	</script>
</body>
</html>

