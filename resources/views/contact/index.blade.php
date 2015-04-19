@extends('app')

@section('content')
<div class="column medium">
	<div class="module contact-module">
		<h2>Contact Us</h2>
		<p>Have a suggestion? Feedback on the site? Want to say hi, or rage about your recent losses?</p>
		<p>Send us a message using the form below. If you want a response, include an email for us to contact you on.</p>
		{!! Form::open(array('url' => '/api/site/contact')) !!}
			{!! Form::label('email', 'Enter your email (optional):'); !!}
			{!! Form::email('email', '', ['placeholder' => 'you@example.com']); !!}

			{!! Form::label('message', 'Enter your message:'); !!}
			{!! Form::textarea('message', '', ['placerholder' => 'Hey Bookie.GG ...']) !!}

			{!! Form::submit('Submit', ['class' => 'btn btn-primary', 'required'=>'required']) !!}
		{!! Form::close() !!}
	</div>
</div>
@endsection