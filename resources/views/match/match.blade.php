{{-- */ $wideLayout=true; /*--}}
@extends('app')

{{-- */ $userBet = []; $x = rand(0,0); for($i=0; $i<$x;$i++) { $userBet[] = $weapons[rand(0, count($weapons)-1)]; } /*--}}
{{-- */ $userInv = []; $x = rand(10,20); for($i=0; $i<$x;$i++) { $userInv[] = $weapons[rand(0, count($weapons)-1)]; } /*--}}
{{-- */ $userBetTeam = "Cloud9"; /*--}}
{{-- */ $streams = []; if (rand(1,2)) { $streams = ["English", "Russian", "French"]; } /*--}}
{{-- */ if (!isset($match->bet_info)) { $match->bet_info = ["users" => 256, "items" => 128, "worth" => "512"]; } /*--}}

@section('content')
<div class="column medium">
	<div class="module match-module">
		<div class="match-info faint">{{ $match->bet_info["users"] }} users bet {{ $match->bet_info["items"] }} items at a value of {{ $match->bet_info["worth"] }}</div>
		@include('partials/match_overview', array('m' => $match, 'type' => 'match'))
		
		@if(Auth::check())
		<div class="user-bet section">
		@if(!count($userBet))
			@include('partials/inventory', ['items' => $userInv, 'btns' => ['Bet on '.$match->teams[0]->name => 'bet(0)', 'Bet on '.$match->teams[1]->name => 'bet(1)']])
		@else
			<div class="bet-holder">
				<p>You've bet the following on <em>{{ $userBetTeam }}</em>:</p>
				<div class="item-holder flex-wrap">
					@foreach($userBet as $item)
						@include('partials/small_item', ['wep_img' => $item])
					@endforeach
				</div>
			</div>
			@if(count($userBet) < 10)
				@include('partials/inventory', ['items' => $userBet, 'btns' => ['Add to bet' => ''], 'emptyText' => 'Select items to add to bet', 'btnVal' => '-1'])
			@endif
		@endif
		</div>
		@endif
	</div>
</div>
<div class="column small-medium">
	<div class="module">
		<h2>Livestreams</h2>
		@if(count($streams))
		<div class="streams section">
			<ul class="no-padding flex-fill">
				@foreach($streams as $lang)
					<li class="btn btn-vert">{{ $lang }}</li>
				@endforeach
			</ul>
		</div>
		@endif
	</div>
</div>
@endsection