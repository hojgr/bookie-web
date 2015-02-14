<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <link href="{{ elixir('css/beta.css') }}" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700,100,900' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container">
        <div class="content">
            <h1 class="center">Bookie.GG</h1>
            <h1>Coming Soon
                <span class="fix">&nbsp;</span></h1>
            <h2>A Revolution for Esports Betting
                <span class="fix">&nbsp;</span></h2>
            <img class="logo" src="{{ asset('images/logo_beta.png') }}" />
            @if (!Auth::user() || Auth::user()->subscription === null)
                <h2>Sign Up for Updates and Beta Access
                <span class="fix">&nbsp;</span></h2>
            @endif
        @if (!Auth::check())
                <a href="{{ action("SteamController@login") }}" class="connect"><img src="{{ asset('images/steamsignin.png') }}"/></a>
            @else
                <div class="userbox" style="position: relative">
                    <img src="{{ Auth::user()->getAvatarUrl() }}">
                    <div class="right">
                        <span>Logged in as:</span>
                        <h2>{{ Auth::user()->display_name }}</h2>
                        <a style="color: white; position: absolute; top: 0; right: 0; padding: 20px" href="{{ route('logout') }}">Logout</a>
                    </div>
                    <div class="clr"></div>
                </div>
                @if (Auth::user()->subscription !== null)
                    <div class="signed_up">
                        <h3>You have signed up for closed beta.</h3>
                        When you account is activated you will receive an e-mail informing you so.
                    </div>
                @else
                    @foreach($errors->all() as $error)
                        <span class="error" style="color: white">{{ $error }}</span>
                    @endforeach

                    {!! Form::open(['route' => 'subscribe']) !!}
                    {!! Form::text('email', null, array('placeholder' => 'Your Email')) !!}
                    {!! Form::text('name', null, array('placeholder' => 'Your Name')) !!}

                    {!! Form::submit('Sign Up') !!}
                    {!! Form::close() !!}
                @endif
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>

