@extends('app')

@section('content')
    <div class="header">
        <div class="logo"><h1>Bookie.GG</h1></div>
        <div class="nav">
            <ul>
                <li class="active">Matches</li>
                <li>Bank</li>
                <li>Forums</li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="left-side">
            <div class="user-left">
                @if (!Auth::check())
                    <div class="steam-button">
                        <a href="{{ action("SteamController@login") }}" class="connect"><img src="{{ asset('images/steamsignin.png') }}"/></a>
                    </div>
                @else
                    <div class="username-container">
                        <div class="avatar">
                            <img src="{{ SteamUtil::avatarPathToAvatarURL(Auth::user()->avatar_path) }}" />
                        </div>
                        <h2>{{ Auth::user()->display_name }}</h2>
                    </div>
                    <ul>
                        <li>Bets</li>
                        <li>Settings</li>
                    </ul>
                @endif
            </div>
            <div class="news-left">
                News
                <ul>
                    <li>blank stuff</li>
                    <li>blank stuff</li>
                    <li>blank stuff</li>
                    <li>blank stuff</li>
                    <li>blank stuff</li>
                </ul>
            </div>
        </div>
        <div class="content">
            <div class="matchbox">
                <div class="team1">
                    {{--<div class="team-image">--}}
                    <img height="75px" src="{{ asset('images/teams/virtus.pro.png') }}" />
                    {{--</div>--}}
                    <div class="team-name">Virtus.pro</div>
                </div>
                <div class="team2">
                    <div class="team-name">Cloud 9</div>
                    {{--<div class="team-image">--}}
                    <img height="75px" src="{{ asset('images/teams/cloud_9.png') }}" />
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
