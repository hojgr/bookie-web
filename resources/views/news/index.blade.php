@extends('app')

@section('content')
	<div class="content-box">
		<div style="padding: 10px">
			<h1>{{ $article->title }}</h1>
			<hr>
			<div style="text-align: justify">
				{!! $article->content !!}
			</div>
		</div>
	</div>
@endsection


@section('rightside')
	<div class="right-side">
		<div style="padding: 10px">
			Written by <b>{{ $article->user->display_name }}</b><br />
			{{ $article->created_at->format('m.d.Y H:i:s') }}
		</div>
	</div>
@endsection
