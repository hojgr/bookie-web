@extends('app')

@section('content')
	@foreach($matches as $m)
		<div class="matchbox">
			<div class="team1 {{ ($m->teams[0]->id == $m->winner_id ? 'winner' : ($m->winner_id == 0 ? '' : 'loser')) }}">
				<div class="logo">
					{!! LogoUtil::renderBig($m->teams[0]) !!}
					@if($m->teams[0]->id == $m->winner_id)
						<div style="clear: both; width: 75px; text-align: center; color: #00E600"><b>Winner</b></div>
					@elseif($m->winner_id != 0)
						<div style="clear: both; width: 75px; text-align: center;">Loser</div>
					@endif

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
	@foreach($matches as $m)
		<div class="right-side placed_bets">
			<span class="title">Placed items (example!)</span>

			<div style="height: 110px; margin-top: 36px" class="scroller">
				@for($i=0;$i<10;$i++)
					<div class="itembox">
						<div class="stattrak">ST</div>
						<div class="price">$0.00</div>
						<div class="image">
							<img src="{{ $weapons[rand(0, count($weapons)-1)] }}" />
						</div>
						<div class="wear mw">Minimum Wear</div>
					</div>
				@endfor
			</div>
		</div>
	@endforeach

	<script>
		$(document).ready(function() {
			$(".scroller").simplyScroll();
		});
	</script>
@endsection