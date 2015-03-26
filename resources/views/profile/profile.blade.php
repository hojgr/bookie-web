@extends('app')

@section('content')
<div class="column">
	<div class="module profile-module">
		<h1>My Profile</h1>

		<div class="input-group">
			<label for="steam-trade-url">Steam trade URL:</label>
			<input type="text" value="{{ $tradeUrl }}" id="steam-trade-url" placeholder="Enter your Steam trade URL">
		</div>
	</div>
</div>

<div class="column">
	<div class="module history-module">
		<h1>Match history</h1>

		@if(count($matchHistory))
		<table class="match-history">
			<tbody>
				@foreach($matchHistory as $m)
				<tr>
					{{--*/ $resultStr = "Lost"; if($m->userBet == $m->winner){ $resultStr = "Won"; }  if ($m->winner == 0) { $resultStr = "Draw"; } /*--}}
					<td class="{{ strtolower($resultStr) }}"><a href="/match/{{ $m->matchId }}">{{ $resultStr }}</a></a></td>
					<td class="team team-1 @if($m->winner==1) winner @endif"><a href="/match/{{ $m->matchId }}">{{ $m->team_1 }}</a></td>
					<td><a href="/match/{{ $m->matchId }}">vs.</a></td>
					<td class="team team-2 @if($m->winner==2) winner @endif"><a href="/match/{{ $m->matchId }}">{{ $m->team_2 }}</a></td>
					<td class="time"><a href="/match/{{ $m->matchId }}">{{ $m->timeStr }}</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@endif
	</div>
</div>
@endsection