@extends('app')

@section('content')
	@foreach($matches as $m)
		<div class="matchbox">
			<div class="team1">
				<div class="logo">
					{!! LogoUtil::renderBig($m->teams[0]) !!}
				</div>
				<div class="info">
					<div class="team-name">{{ (strlen($m->teams[0]->name) > 10) ? $m->teams[0]->short_name: $m->teams[0]->name }}</div>
					<div class="odds">99%</div>
				</div>
			</div>

			<div class="organization">
				{!! LogoUtil::renderSpecial($m->organization, 100) !!}
			</div>

			<div class="team2">
				<div class="logo">
					{!! LogoUtil::renderBig($m->teams[1]) !!}
				</div>

				<div class="info">
					<div class="team-name">{{ (strlen($m->teams[1]->name) > 10) ? $m->teams[1]->short_name: $m->teams[1]->name }}</div>
					<div class="odds">99%</div>
				</div>
			</div>
			<div style="clear: both"></div>

			<div class="details">
				<div class="time-from-now">{{ TimeUtil::formatTimestampFromNow($m->start) }} from now</div>
				<div class="bo-style"><span>Best of {{ $m->bo }}</span></div>
				<div class="time-start">{{ TimeUtil::formatTimestamp($m->start) }}</div>
			</div>
		</div>
	@endforeach
@endsection
