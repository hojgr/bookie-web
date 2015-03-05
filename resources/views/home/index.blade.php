@extends('app')

@section('content')
	@foreach($matches as $k => $m)
		<div class="matchbox @if($k == $first_key || $k == $first_finished_key) matchbox-has-title @endif">
			@if($k == $first_key)
				<div class="matchbox-title">Upcoming matches</div>
			@elseif($k == $first_finished_key)
				<div class="matchbox-title">Finished matches</div>
			@endif

			<div class="team1 {{ ($m->teams[0]->id == $m->winner_id ? 'winner' : ($m->winner_id == 0 ? '' : 'loser')) }}">
				<div class="logo">
					{!! LogoUtil::renderBig($m->teams[0]) !!}
					<div style="clear: both; width: 75px; text-align: center; height: 15px;">
						@if($m->teams[0]->id == $m->winner_id)
							<b style="color: #00E600">Winner</b>
						@elseif($m->winner_id != 0)
							Loser
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
					@elseif($m->winner_id != 0)
						<div style="clear: both; width: 75px; text-align: center;">Loser</div>
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
		</div>
	@endforeach
@endsection

@section('rightside')
	@foreach($matches as $k => $m)
		@if($m->winner_id == 0)
			<div class="right-side placed_bets @if($k == $first_key) placed-bets-title-side @endif">
				@if($k == $first_key)
					<div class="placed-bets-title">Your bets (example)</div>
				@endif

					<div class="placed-title">You have these placed on <b>{{ $m->teams[0]->short_name }}</b></div>

					<div style="height: 110px; margin-top: 7px" class="scroller">
						@for($i=0;$i<10;$i++)
							<div class="itembox">
								<div class="stattrak">ST</div>
								<div class="price">$0.00</div>
								<div class="image">
									<img alt="csgo weapon" src="{{ $weapons[rand(0, count($weapons)-1)] }}" />
								</div>
								<div class="wear mw">Minimal Wear</div>
							</div>
						@endfor
					</div>
			</div>
		@endif
	@endforeach

	<script>
		$(document).ready(function() {
			$(".scroller").simplyScroll();
		});
	</script>
@endsection