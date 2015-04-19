{{-- */ $wideLayout=true; /*--}}
@extends('app')

{{-- */ $streams = []; if (rand(1,2)) { $streams = ["English", "Russian", "French"]; } /*--}}
{{-- */ if (!isset($match->bet_info)) { $match->bet_info = ["users" => 256, "items" => 128, "worth" => "512"]; } /*--}}

@section('content')
<div class="column medium">
	<div class="module match-module">
		<div class="match-info faint">{{ $match->bet_info["users"] }} users bet {{ $match->bet_info["items"] }} items at a value of {{ $match->bet_info["worth"] }}</div>
		@include('partials/match_overview', array('m' => $match, 'type' => 'match'))

		@if(Auth::check())
		<div class="user-bet section">
		@if(!count($userBet->items) || true)
			@include('partials/inventory', ['submitUrl' => '/api/csgo/bet', 'items' => $userInv, 'btns' => ['Bet on '.$match->teams[0]->name => 'bet(0)', 'Bet on '.$match->teams[1]->name => 'bet(1)'], 'data'=>['match'=>$match->id], 'submitTeam' => true])
		@else
			<div class="bet-holder">
				<div class="flex-between flex-center">
					<p>You've bet the following on <em>{{ $match->teams[$userBet->team]->name }}</em>:</p>
					{!! Form::open(array('url' => '/api/csgo/bet/switch', 'class' => 'no-style')) !!}
						{!! Form::hidden('bet', $userBet->id) !!}
						{!! Form::hidden('team', 1-$userBet->team) !!}
						{!! Form::button('Switch to '.$match->teams[1-$userBet->team]->short_name, ['class'=>'btn-primary', 'type'=>'submit']) !!}
					{!! Form::close() !!}
				</div>
				<div class="item-holder flex-wrap">
					@foreach($userBet->items as $item)
						@include('partials/small_item', ['item' => $item])
					@endforeach
				</div>
			</div>
			@if(count($userBet->items) < 10)
				@include('partials/inventory', ['submitUrl' => '/api/csgo/bet','items' => $userInv, 'btns' => ['Add to bet' => ''], 'emptyText' => 'Select items to add to bet', 'btnVal' => '-1', 'data'=>['match'=>$match->id], 'submitTeam' => true])
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