@extends('app')

@section('content')
<div class="column medium">
	<div class="module getting-started-module">
		<h2>Getting started</h2>
		<div class="row flex-fill">
			<img class="padded" src="{{ asset('images/help/1.svg') }}">
			<div class="text-content flex-center padded">
				<p>Go to your <a href="/profile/me">"My Profile"</a> page and enter your Steam trading URL.</p>
			</div>
		</div>

		<div class="row flex-fill">
			<div class="text-content flex-center padded">
				<p>Then go to your <a href="/bank">"Bank"</a> page to deposit items you wish to bet with.</p>
			</div>
			<img class="padded" src="{{ asset('images/help/2.svg') }}">
		</div>

		<div class="row flex-fill">
			<img class="padded" src="{{ asset('images/help/3.svg') }}">
			<div class="text-content flex-center padded">
				<p>Find a match that you wish to bet on, and place a bet on your preferred team.</p>
			</div>
		</div>

		<div class="row flex-fill">
			<div class="text-content flex-center padded">
				<p>When the match has started, it can be viewed by clicking your preferred language stream on the match page</p>
			</div>
			<img class="padded" src="{{ asset('images/help/4.svg') }}">
		</div>

		<div class="row flex-fill">
			<img class="padded" src="{{ asset('images/help/5.svg') }}">
			<div class="text-content flex-center padded">
				<p>To withdraw your winnings go to your <a href="/bank">"Bank"</a> page and select all the items you want back into your Steam inventory.</p>
			</div>
		</div>

		<div class="row flex-fill">
			<div class="text-content flex-center padded">
				<p>Wait for one of our automated Bookkeepers to send you a trade offer, make sure everything is correct, then accept the offer.</p>
			</div>
			<img class="padded" src="{{ asset('images/help/6.svg') }}">
		</div>
	</div>
</div>
@endsection