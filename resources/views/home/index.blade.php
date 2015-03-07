@extends('app')

@section('content')
	@foreach($matches as $k => $m)
		@if($k == $keys['upcoming'])
			<div class="matchbox-title">Upcoming matches</div>
		@elseif($k == $keys['finished'])
			<div class="matchbox-title">Finished matches</div>
		@elseif($k == $keys['live'])
			<div class="matchbox-title">Live matches</div>
		@endif

		<div class="matchbox @if($m->note) matchbox-has-note @endif">

			<div class="team1 {{ ($m->teams[0]->id == $m->winner_id ? 'winner' : ($m->winner_id == 0 ? '' : 'loser')) }}">
				<div class="logo">
					{!! LogoUtil::renderBig($m->teams[0]) !!}
					<div style="clear: both; width: 75px; text-align: center; height: 15px;">
						@if($m->teams[0]->id == $m->winner_id)
							<b style="color: #00E600">Winner</b>
						@endif
					</div>

				</div>
				<div class="info">
					<div class="team-name">
						{{ (strlen($m->teams[0]->name) > 10) ? $m->teams[0]->short_name: $m->teams[0]->name }}
					</div>
					<div class="odds">50%</div>
				</div>
			</div>

			<div class="organization">
				{!! LogoUtil::renderSpecial($m->organization, 100) !!}
			</div>

			<div class="team2 {{ ($m->teams[1]->id == $m->winner_id ? 'winner' : ($m->winner_id == 0 ? '' : 'loser')) }}">
				<div class="logo">
					{!! LogoUtil::renderBig($m->teams[1]) !!}
					@if($m->teams[1]->id == $m->winner_id)
						<div style="clear: both; width: 75px; text-align: center; color: #00E600"><b>Winner</b></div>
					@endif
				</div>

				<div class="info">
					<div class="team-name">
						{{ (strlen($m->teams[1]->name) > 10) ? $m->teams[1]->short_name: $m->teams[1]->name }}
					</div>
					<div class="odds">50%</div>
				</div>
			</div>
			<div style="clear: both"></div>

			<div class="details @if($m->winner_id != 0) greyout @endif">
				<div class="time-from-now">{{ TimeUtil::formatTimestampFromNow($m->start) }}</div>
				<div class="bo-style"><span>Best of {{ $m->bo }}</span></div>
				<div class="time-start">{{ TimeUtil::formatTimestamp($m->start) }}</div>
			</div>
				<div style="clear: both"></div>
			@if($m->note)
				<div class="match-note">
					<span class="match-note-title">Notes:</span>
					<span class="match-note-text">{!! Note::format($m->note->note) !!}.</span>
				</div>
			@endif
		</div>
	@endforeach
@endsection

@section('rightside')
	@foreach($matches as $k => $m)
		@if($m->winner_id == 0)
			<div class="right-side placed_bets @if(in_array($k, [$keys['upcoming'], $keys['live']])) placed-bets-title-side @endif @if($m->note) placed-bets-has-note @endif placed-bets-has-items">
				@if($k == $keys['live'])
					<div class="placed-bets-title">Your bets on live matches</div>
				@elseif($k == $keys['upcoming'])
					<div class="placed-bets-title placed-bets-title-small">Your bets on upcoming matches</div>
				@endif

					{{-- */ $x = rand(0, 10); /*--}}
					<div class="placed-title">You bet these items on <b>{{ $m->teams[0]->short_name }}</b></div>

					<div class="item-holder @if($k == $keys['upcoming']) item-holder-tall @endif">
						@for($i=0;$i<10;$i++)
							@if($i < $x)
								@include('partials/small_item', ['wep_img' => $weapons[rand(0, count($weapons)-1)]])
							@else
								<div class="itembox small" data-contains="empty">Empty</div>
							@endif
						@endfor
					</div>
					{{-- @if($m->note)
						<div class="match-note-items"></div>
					@endif --}}
			</div>
		@endif
	@endforeach

@endsection