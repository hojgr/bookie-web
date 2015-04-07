@extends('app')

@section('content')
<div class="column small-medium">
	<div class="module profile-module">
		<h2>My Profile</h2>

		{!! Form::open(array('url' => '/api/profile/tradeurl')) !!}
		<div class="input-container">
			<label for="steam-trade-url">Steam trade URL:</label>
			<input type="text" value="{{ $tradeUrl }}" id="steam-trade-url" placeholder="Enter your Steam trade URL">
		</div>
		{!! Form::button("Save settings", array('onclick'=>'saveSettings()', 'class'=>'btn-primary', 'type'=>'submit')) !!}
		{!! Form::close() !!}
	</div>
</div>

<div class="column">
	<div class="module history-module">
		<h2>Match history</h2>

		@if(count($matchHistory))
		<table class="match-history">
			<tbody>
				@foreach($matchHistory as $m)
				<tr class="{{ $m->userBet == $m->winner ? 'win' : $m->winner == 0 ? 'draw' : 'loss' }}">
					{{--*/ $resultStr = "Lost"; if($m->userBet == $m->winner){ $resultStr = "Won"; }  if ($m->winner == 0) { $resultStr = "Draw"; } /*--}}
					<td><a class="noblue" href="/match/{{ $m->matchId }}">{{ $resultStr }}</a></a></td>
					<td class="team-1 @if($m->winner==1) winner @endif"><a class="noblue" href="/match/{{ $m->matchId }}">{{ $m->team_1 }}</a></td>
					<td><a class="noblue" href="/match/{{ $m->matchId }}">vs.</a></td>
					<td class="team-2 @if($m->winner==2) winner @endif"><a class="noblue" href="/match/{{ $m->matchId }}">{{ $m->team_2 }}</a></td>
					<td class="time"><a class="noblue" href="/match/{{ $m->matchId }}">{{ $m->timeStr }}</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@endif
	</div>
</div>
@endsection