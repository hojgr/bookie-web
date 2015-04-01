{{-- */ $wideLayout=true; /*--}}
@extends('app')

@section('content')
<div class="column large">
	@foreach(['Upcoming'=>$upcoming_matches, 'Live'=>$live_matches, 'Finished'=>$past_matches] as $t => $a)
		@if(count($a))
		<div class="module match-container-module no-padding">
			<div class="row">
				<div class="sub-column medium header-column match-column">
					<h2>{{ $t }} matches</h2>
				</div>
				<div class="sub-column small-medium header-column items-column">
					<h2>Your bets on {{ strtolower($t) }} matches</h2>
				</div>
			</div>

			@foreach($a as $k => $m)
			<div class="row">
				<div class="sub-column medium match-column">
					@include('partials/match_overview', array('m' => $m, 'type' => 'home'))
				</div>

				{{-- */ $x = rand(0,10); /*--}}
				<div class="sub-column small-medium flex-center items-column @if($x==0) empty @endif">
					<p class="visible-sm">You bet:</p>
					<div class="placed-items">						
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
				</div>
			</div>
			@endforeach
		</div>
		@endif
	@endforeach
</div>
@endsection('content')
