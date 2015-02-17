@extends('app')

@section('content')
	<div class="matchbox">
		<div class="team1">
			<img height="75px" src="{{ asset('images/teams/virtus.pro.png') }}" />
			<div class="team-name">Virtus.pro</div>
		</div>
		<div class="team2">
			<div class="team-name">Cloud 9</div>
			<img height="75px" src="{{ asset('images/teams/cloud_9.png') }}" />
		</div>
	</div>
	<div class="streambox"></div>
@endsection
