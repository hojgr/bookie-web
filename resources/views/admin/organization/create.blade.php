@extends('admin/app')

@section('content')
	<div class="content-box">
		<h2>Add organization</h2>

		<ul class="validation">
			@foreach($errors->all() as $error)
				<li class="error">{{ $error }}</li>
			@endforeach
		</ul>

		{!! Form::open(['route' => 'admin.organization.store', 'files' => 'true']) !!}

		<table class="form-table">
			<tr>
				<td>{!! Form::label('name', 'Organization') !!}</td>
				<td>{!! Form::text('name', null, ['placeholder' => 'Valve', 'class' => 'form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('url', 'Website') !!}</td>
				<td>{!! Form::text('url', null, ['placeholder' => 'http://site.com', 'class' => 'form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('logo', 'Logo') !!}</td>
				<td>{!! Form::file('logo') !!}</td>
			</tr>

			<tr>
				<td></td>
				<td>{!! Form::submit('Add new organization', ['class' => 'btn btn-primary']) !!}</td>
			</tr>

		</table>


		{!! Form::close() !!}
	</div>
@endsection



