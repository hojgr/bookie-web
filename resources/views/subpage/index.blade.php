@extends('app')

@section('content')
<div class="column medium">
	<div class="module sub-module">
		<h2>{{ $data->name }}</h2>
		<div class="text-content">
			{!! $data->content !!}
		</div>
	</div>
</div>
@endsection
