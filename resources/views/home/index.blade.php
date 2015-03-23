@extends('app')

@section('content')
<div class="column match-column-container">
	@foreach(['upcoming'=>'upcoming', 'live'=>'live', 'finished'=>'past'] as $t => $s)
	<div class="column column-container">
		<div class="sub-column match-column">
			@foreach($matches as $k => $m)
			@if($m->type == $t)
				@if($k == $keys[$t])
					<h1>{{ ucfirst($s) }} matches</h1>
				@endif
				<div class="matchbox @if($m->note)has-note @endif">
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
								@elseif($m->winner_ids != 0)
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

					<div class="match-details @if($m->winner_id != 0) greyout @endif">
						<div class="time-from-now">{{ TimeUtil::formatTimestampFromNow($m->start) }}</div>
						<div class="bo-style"><span>Best of {{ $m->bo }}</span></div>
						<div class="time-start">{{ TimeUtil::formatTimestamp($m->start) }}</div>
					</div>

					@if($m->note)
						<div class="match-note">
							<h4>Notes:</h4>
							<span class="match-note-text">{!! Note::format($m->note->note) !!}.</span>
						</div>
					@endif
				</div>
			@endif
			@endforeach
		</div>

		<div class="sub-column items-column">
			@foreach($matches as $k => $m)
			@if($m->type == $t)
				@if($k == $keys[$t])
					<h1>Your bets on {{ $s }} matches</h1>
				@endif
				<div class="placed-items @if($m->note)has-note @endif">
					{{-- */ $x = rand(0,10); /*--}}
					<div class="placed-title">You bet these items on <b>{{ $m->teams[0]->short_name }}</b></div>

					@for($j=0;$j<2;$j++)
						<div class="item-holder">
						@for($i=0;$i<5;$i++)
							@if($i < $x)
								@include('partials/small_item', ['wep_img' => $weapons[rand(0, count($weapons)-1)]])
							@else
								<div class="itembox small" data-contains="empty"></div>
							@endif
						@endfor
						</div>
					@endfor
				</div>
			@endif
			@endforeach
		</div>
	</div>
	@endforeach
</div>
@endsection('content')
