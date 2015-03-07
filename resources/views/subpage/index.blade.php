@extends('app')

@section('content')
	<div class="content-box {{ strtolower(preg_replace('/ /', '-', $data->name)) }}">
		{!! $data->content !!}
	</div>
@endsection
