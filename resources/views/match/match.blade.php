@extends('app')

{{-- */ $userBet = []; $x = rand(1,10); for($i=0; $i<$x;$i++) { $userBet[] = $weapons[rand(0, count($weapons)-1)]; } /*--}}

@section('content')
<div class="column">
	<div class="module match-module">
		@include('partials/match_overview', array('m' => $match, 'type' => 'match'))
		
		<!-- If user has yet to bet -->
		<div class="user-bet">
			<h1>Betting <button disabled id="bet-team-1" class="btn btn-right btn-primary">Bet on {{ $match->teams[0]->name }}</button><button disabled id="bet-team-2" class="btn btn-right btn-primary">Bet on {{ $match->teams[1]->name }}</button></h1>
			@include('partials/inventory', ['items' => $userBet, 'btns' => ['#bet-team-1', '#bet-team-2']])
		</div>

		@if(count($streams))
		<div class="streams">
			<a class="btn btn-wide btn-primary">Show livestreams</a>
			<div class="stream-container hidden">
				<ul class="languages">
					@foreach($streams as $lang => $url)
						<li class="btn" for="{{ strtolower($lang) }}-stream">{{ $lang }}</li>
					@endforeach
				</ul>
				@foreach($streams as $lang => $url)
					<iframe id="{{ strtolower($lang) }}-stream" class="stream" style="display: none" src="{{ $url }}" frameborder="0" scrolling="no" height="378" width="620"></iframe>
				@endforeach
			</div>
		</div>
		@endif

		<!-- If user has bet -->
		<div class="user-bet">
			<h1>Betting</h1>
			<h3>You placed the following items on <em>Cloud9</em>:</h3>
			<div class="item-list">
			@foreach($userBet as $url)
				@include('partials/small_item', ['wep_img' => $url])
			@endforeach
			</div>

			<!-- If user can add more items to bet -->
			<h3>Add items to your bet:</h3>
			@include('partials/inventory', ['items' => $userBet])
		</div>
	</div>
</div>
@endsection