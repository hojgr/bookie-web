@extends('app')

{{-- */ $userBet = []; $x = rand(1,10); for($i=0; $i<$x;$i++) { $userBet[] = $weapons[rand(0, count($weapons)-1)]; } /*--}}

@section('content')
<div class="column">
	<div class="module match-module">
		@include('partials/match_overview', array('m' => $match, 'type' => 'match'))
		
		@if(count($streams))
		<div class="streams">
			<a class="btn-wide">Show livestreams</a>
			<div class="stream-container hidden">
				<ul class="languages">
					@foreach($streams as $lang => $url)
						<li for="{{ strtolower($lang) }}-stream">{{ $lang }}</li>
					@endforeach
				</ul>
				@foreach($streams as $lang => $url)
					<iframe id="{{ strtolower($lang) }}-stream" class="stream" style="display: none" src="{{ $url }}" frameborder="0" scrolling="no" height="378" width="620"></iframe>
				@endforeach
			</div>
		</div>
		@endif

		<div class="user-bet">
			<h1>Betting</h1>
			<h3>You placed the following items on <em>Cloud9</em>:</h3>
			<div class="item-list">
			@foreach($userBet as $url)
				@include('partials/small_item', ['wep_img' => $url])
			@endforeach
			</div>
		</div>
	</div>
</div>
@endsection