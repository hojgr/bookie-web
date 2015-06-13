{{-- */ $wideLayout=true; /*--}}
@extends('app')

@section('content')
<div class="column medium keep-size">
	<div class="module profile-module">

	</div>
	<div class="module settings-module">
		<h2>My Settings</h2>

		{!! Form::open(array('url' => '/api/profile/tradeurl', 'class' => 'no-style')) !!}
		<div class="input-group">
			<label for="steam-trade-url">Steam trade URL <a target="_blank" href="http://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url">(get it here)</a>:</label>
			<input type="text" data-verify-url="/api/profile/tradeurl" name="tradeURL" value="{{ $tradeUrl }}" id="steam-trade-url" placeholder="Enter your Steam trade URL">
			<div class="focus-indicator"></div>
		</div>
		{!! Form::button("Submit", array('class'=>'btn-primary btn-wide', 'type'=>'submit')) !!}
		{!! Form::close() !!}
	</div>
</div>

<div class="column small-medium">
	<div class="module history-module">
		<h2>Match history</h2>

		@if(count($matchHistory))
		<table class="match-history">
			<tbody>
				@foreach($matchHistory as $m)
				<tr class="{{ $m->userBet == $m->winner ? 'win' : $m->winner == 0 ? 'draw' : 'loss' }}">
					{{--*/ $resultStr = "Lost"; if($m->userBet == $m->winner){ $resultStr = "Won"; }  if ($m->winner == 0) { $resultStr = "Draw"; } /*--}}
					<td><a class="result no-style" href="/match/{{ $m->matchId }}"></a></a></td>
					<td class="team-1 @if($m->winner==1) winner @endif"><a class="no-style" href="/match/{{ $m->matchId }}">{{ $m->team_1 }}</a></td>
					<td><a class="no-style" href="/match/{{ $m->matchId }}">vs.</a></td>
					<td class="team-2 @if($m->winner==2) winner @endif"><a class="no-style" href="/match/{{ $m->matchId }}">{{ $m->team_2 }}</a></td>
					<td class="time"><a class="no-style" href="/match/{{ $m->matchId }}">{{ $m->timeStr }}</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@endif
	</div>
</div>
@endsection