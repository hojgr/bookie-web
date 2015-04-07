@section('details')
	<div class="faint flex-fill flex-fill-text match-details @if($m->winner_id != 0) greyout @endif">
		<div class="time-from-now">{{ TimeUtil::formatTimestampFromNow($m->start) }}</div>
		<div class="bo-style"><span>Best of {{ $m->bo }}</span></div>
		<div class="time-start">{{ TimeUtil::formatTimestamp($m->start) }}</div>
	</div>
@endsection

{{--*/ if (!isset($m->odds)) { $x = rand(1,99); $m->odds = [$x, 100-$x];}  /*--}}
@if($type != 'match')<a class="no-style matchbox-link" href="/match/{{ $m->id }}">@endif
<div class="matchbox">
	@yield('details')

	<div class="flex-fill flex-nowrap match-data">
		<div class="flex-between flex-center team-1 {{ ($m->teams[0]->id == $m->winner_id ? 'winner' : ($m->winner_id == 0 ? '' : 'loser')) }}">
			{!! LogoUtil::renderBig($m->teams[0]) !!}

			<div class="team-info">
				<div class="team-name">
					{{ (strlen($m->teams[0]->name) > 10) ? $m->teams[0]->short_name: $m->teams[0]->name }}
				</div>
				<div class="team-odds">{{ $m->odds[0] }}%</div>
				@if($m->winner_id != 0)
					@if($m->teams[0]->id == $m->winner_id)
					<div class="team-status">Winner</div>
					@elseif($m->winner_id != 0)
					<div class="team-status">Loser</div>
					@endif
				@else
					{{--*/ $rate = $m->odds[0] == 0 ? "0.00" : $m->odds[1] == 0 ? "0.00" : number_format($m->odds[1]/$m->odds[0]*0.98, 2, '.', '') /*--}}
					@if($type == "match")
						<div class="team-status" title="For every 1 value you bet, you are able to win another {{ $rate }} from winning">{{ $rate }} : 1</div>
					@endif
				@endif
			</div>
		</div>

		<div class="flex-around flex-center organization">
			{!! LogoUtil::renderSpecial($m->organization, 100) !!}
		</div>

		<div class="flex-between flex-center team-2 {{ ($m->teams[1]->id == $m->winner_id ? 'winner' : ($m->winner_id == 0 ? '' : 'loser')) }}">
			<div class="team-info">
				<div class="team-name">
					{{ (strlen($m->teams[1]->name) > 10) ? $m->teams[1]->short_name: $m->teams[1]->name }}
				</div>
				<div class="team-odds">{{ $m->odds[1] }}%</div>
				@if($m->winner_id != 0)
					@if($m->teams[1]->id == $m->winner_id)
					<div class="team-status">Winner</div>
					@else
					<div class="team-status">Loser</div>
					@endif
				@else
					{{--*/ $rate = $m->odds[0] == 0 ? "0.00" : $m->odds[1] == 0 ? "0.00" : number_format($m->odds[0]/$m->odds[1]*0.98, 2, '.', '') /*--}}
					@if($type == "match")
						<div class="team-status" title="For every 1 value you bet, you are able to win another {{ $rate }} from winning">1 : {{ $rate }}</div>
					@endif
				@endif
			</div>

			{!! LogoUtil::renderBig($m->teams[1]) !!}
		</div>
	</div>


	@if($m->note)
		<div class="match-note">
			<h4>Notes:</h4>
			<span class="match-note-text">{!! Note::format($m->note->note) !!}.</span>
		</div>
	@endif
</div>
@if($type != 'match')</a>@endif