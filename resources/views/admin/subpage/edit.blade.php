@extends('admin/app')

@section('content')
	<div class="content-box">
		<script src="//cdn.ckeditor.com/4.4.7/standard/ckeditor.js"></script>
		<h2>Edit subpage</h2>

		<ul class="validation">
			@foreach($errors->all() as $error)
				<li class="error">{{ $error }}</li>
			@endforeach
		</ul>

		{!! Form::open(['url' => route('admin.subpage.update', $subpage->id), 'method' => 'PATCH']) !!}

		{!! Form::label('name', 'Subpage name') !!}
		{!! Form::text('name', $subpage->name, ['placeholder' => 'Terms of Service', 'class' => 'form-control']) !!}
		<small>Changing name will break the subpage! Do not do it! Never. Only <b>teb</b> can do it.</small>
		<br />
		<br />
		{!! Form::label('content', 'Content') !!}
		{!! Form::textarea('content', $subpage->content, ['placeholder' => 'Content of subpage', 'class' => 'form-control']) !!}

		<br />

		{!! Form::submit('Edit subpage', ['class' => 'btn btn-primary']) !!}

		<script>
			// Replace the <textarea id="editor1"> with a CKEditor
			// instance, using default configuration.
			CKEDITOR.replace('content');
		</script>

		{!! Form::close() !!}
	</div>
@endsection

@section('rightside')
	<div class="right-side">
		<h3 style="margin-left: 10px">All subpages</h3>
		<ul>
			@foreach($subpages as $s)
				<li>
					<a href="{{ route('admin.subpage.edit', $s->id) }}">{{ str_limit($s->name, 32) }}</a>
				</li>
			@endforeach
		</ul>
	</div>
@endsection



