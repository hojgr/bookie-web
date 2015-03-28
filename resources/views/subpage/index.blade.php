@extends('app')

@section('content')
<div class="column medium-column">
	<div class="module sub-module">
		<h1>{{ $data->name }}</h1>
		<div class="module-content">
			{!! $data->content !!}
		</div>
	</div>
</div>
@endsection
