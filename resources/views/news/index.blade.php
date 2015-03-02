@extends('app')

@section('content')
	<div class="content-box">
		<div style="padding: 10px">
			<h1>{{ $article->title }}</h1>
			<small>{{ $article->created_at->format('n/j/Y H:i') }}</small>
			<hr>
			<div style="text-align: justify">
				{!! $article->content !!}
			</div>
		</div>
	</div>
@endsection