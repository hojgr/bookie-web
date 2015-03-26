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
				@include('partials/match_overview', array('m' => $m, 'type' => 'home'))
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
