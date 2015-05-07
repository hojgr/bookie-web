@extends('app')

@section('content')
	<div class="column medium">
		<div class="module article-module">
			<h2>{{ $article->title }}</h2>
			<small>{{ $article->created_at->format('n/j/Y H:i') }}</small>
			<div class="text-content">
				{!! $article->content !!}
			</div>
		</div>
	</div>
@endsection