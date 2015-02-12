@extends('app')

@section('content')
    <div class="container">
        <div class="content">
            <h1 class="center">Bookie.GG</h1>
            <h1>Coming Soon
                <span class="fix">&nbsp;</span></h1>
            <h2>A Revolution for Esports Betting
                <span class="fix">&nbsp;</span></h2>
            <img class="logo" src="{{ elixir('images/logo_beta.png') }}" />
            @if (!Auth::user() || Auth::user()->signUp === null)
                <h2>Sign Up for Updates and Beta Access
                <span class="fix">&nbsp;</span></h2>
            @endif
        @if (!Auth::check())
                <a href="{{ action("SteamController@login") }}" class="connect"><img src="{{ elixir('images/steamsignin.png') }}"/></a>
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
                @if (Auth::user()->signUp !== null)
                    <div class="signed_up">
                        <h3>You have signed up for closed beta.</h3>
                        When you account is activated you will receive an e-mail informing you so.
                    </div>
                @else
                    @foreach($errors->all() as $error)
                        <span class="error" style="color: white">{{ $error }}</span>
                    @endforeach

                    {!! Form::open(['route' => 'signup']) !!}
                    {!! Form::text('email', null, array('placeholder' => 'Your Email')) !!}
                    {!! Form::text('name', null, array('placeholder' => 'Your Name')) !!}

                    {!! Form::submit('Sign Up') !!}
                    {!! Form::close() !!}
                @endif
            @endif
        </div>
    </div>
@endsection
