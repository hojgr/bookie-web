@section('details')
	<div class="match-details @if($m->winner_id != 0) greyout @endif">
		<div class="time-from-now">{{ TimeUtil::formatTimestampFromNow($m->start) }}</div>
		<div class="bo-style"><span>Best of {{ $m->bo }}</span></div>
		<div class="time-start">{{ TimeUtil::formatTimestamp($m->start) }}</div>
	</div>
@endsection

@if($type != 'match')<a class="matchbox-link" href="/match/{{ $m->id }}">@endif
<div class="matchbox @if($m->note)has-note @endif">
	@yield('details')

	<div class="match-data">
		<div class="team team-1 {{ ($m->teams[0]->id == $m->winner_id ? 'winner' : ($m->winner_id == 0 ? '' : 'loser')) }}">
			{!! LogoUtil::renderBig($m->teams[0]) !!}

			<div class="team-info">
				<div class="team-name">
					{{ (strlen($m->teams[0]->name) > 10) ? $m->teams[0]->short_name: $m->teams[0]->name }}
				</div>
				<div class="team-odds">50%</div>
				@if($m->teams[0]->id == $m->winner_id)
				<div class="team-status">Winner</div>
				@elseif($m->winner_id != 0)
				<div class="team-status">Loser</div>
				@endif
			</div>
		</div>

		<div class="organization">
			{!! LogoUtil::renderSpecial($m->organization, 100) !!}
		</div>

		<div class="team team-2 {{ ($m->teams[1]->id == $m->winner_id ? 'winner' : ($m->winner_id == 0 ? '' : 'loser')) }}">
			{!! LogoUtil::renderBig($m->teams[1]) !!}

			<div class="team-info">
				<div class="team-name">
					{{ (strlen($m->teams[1]->name) > 10) ? $m->teams[1]->short_name: $m->teams[1]->name }}
				</div>
				<div class="team-odds">50%</div>
				@if($m->teams[1]->id == $m->winner_id)
				<div class="team-status">Winner</div>
				@elseif($m->winner_ids != 0)
				<div class="team-status">Loser</div>
				@endif
			</div>
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