@extends('app')

@section('content')
    <div class="container">
        <div class="content">
            <h1 class="center">Bookie.GG</h1>
            <h1>Coming Soon
                <span class="fix">&nbsp;</span></h1>
            <h2>A Revolution for Esports Betting
                <span class="fix">&nbsp;</span></h2>
            <img src="{{ elixir('images/logo_beta.png') }}" />
            @if (Auth::user()->signUp === null)
                <h2>Sign Up for Updates and Beta Access
                <span class="fix">&nbsp;</span></h2>
            @endif
        @if (!Auth::check())
                <a href="{{ action("SteamController@login") }}" class="connect"><img src="{{ elixir('images/steamsignin.png') }}"/></a>
            @else
                <div class="userbox">
                    <img src="{{ Auth::user()->photo_url }}">
                    <div class="right">
                        <span>Logged in as:</span>
                        <h2>{{ auth::user()->display_name }}</h2>
                    </div>
                    <div class="clr"></div>
                </div>
                @if (Auth::user()->signUp !== null)
                    <h3>You have signed up for closed beta.</h3>
                @else
                    @foreach($errors->all() as $error)
                        <span class="error" style="color: white">{{ $error }}</span>
                    @endforeach

                    {!! Form::open(['route' => 'signup']) !!}
                    {!! Form::text('email', null, array('placeholder' => 'Your Email', 'style' => 'color: black')) !!}
                    {!! Form::text('name', null, array('placeholder' => 'Your Name', 'style' => 'color: black')) !!}

                    {!! Form::submit('Sign Up', ['style' => 'color: black']) !!}
                    {!! Form::close() !!}
                @endif
            @endif
                <p class="fine">If you're interested in applying for a position at Bookie.GG, please send all applicable information to jobs@bookie.gg</p>

        </div>
    </div>
@endsection
