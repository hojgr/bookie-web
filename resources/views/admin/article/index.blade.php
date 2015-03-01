@extends('admin/app')

@section('content')
	<div class="content-box">
		<script src="//cdn.ckeditor.com/4.4.7/standard/ckeditor.js"></script>

		<h2>Create new article!</h2>

		{!! Form::open(['route' => 'admin.article.store']) !!}
		{!! Form::text('title', null, array('placeholder' => 'Title of article', 'class' => 'form-control')) !!}<br />
		{!! Form::textarea('text', null, array('placeholder' => 'Text of article')) !!}<br />

		{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
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
		<h3 style="margin-left: 10px">TODO: articles</h3>
	</div>
@endsection