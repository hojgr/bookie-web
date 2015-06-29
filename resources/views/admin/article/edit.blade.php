@extends('admin/app')

@section('content')
	<div class="content-box">
		<script src="//cdn.ckeditor.com/4.4.7/standard/ckeditor.js"></script>

		<h2>Edit!</h2>

		@foreach($errors->all() as $error)
			<span class="error" style="color: white">{{ $error }}</span>
		@endforeach

		{!! Form::open(['url' => route('admin.article.update', $article->id), 'method' => 'PATCH']) !!}
		{!! Form::text('title', $article->title, array('placeholder' => 'Title of article', 'class' => 'form-control')) !!}<br />
		{!! Form::textarea('text', $article->content, array('placeholder' => 'Text of article')) !!}<br />

		{!! Form::submit('Submit changed', ['class' => 'btn btn-primary']) !!}
		{!! Form::close() !!}
		<script>
			// Replace the <textarea id="editor1"> with a CKEditor
			// instance, using default configuration.
			CKEDITOR.replace('text');
		</script>
	</div>
@endsection


@section('rightside')
	<div class="right-side">
		<h3 style="margin-left: 10px">Articles</h3>
		<ul>
			@foreach($articles as $a)
			<li><a href="{{ route('admin.article.edit', $a->id) }}">{{ str_limit($a->title, 32) }}</a></li>
			@endforeach
		</ul>
	</div>
@endsection