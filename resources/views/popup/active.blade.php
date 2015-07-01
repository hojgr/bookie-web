@if ($state == "queue")
	<p>Please wait for a bot to become available.</p>
	<p class="text-center">You are number <em>{{ $data['place'] }}</em> in queue.</p>
@elseif ($state == "offer")
	<p class="text-center">Bot: <em>{{ $data['bot'] }}</em></p>
	<a class="btn" target="_blank" href="{{ $data['url'] }}">You have received an offer</a>
	<p class="text-center">Verification code: <em>{{ $data['code'] }}</em></p>
	<p class="text-center">Time left: <em class="time-left">{{ $data['time-left'] }}</em>s</p>
@endif