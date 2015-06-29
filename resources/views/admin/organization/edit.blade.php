@extends('admin/app')

@section('content')
	<div class="content-box">
		<h2>Edit organization [{{ $organization->name }}]</h2>

		<ul class="validation">
			@foreach($errors->all() as $error)
				<li class="error">{{ $error }}</li>
			@endforeach
		</ul>

		{!! Form::open(['url' => route('admin.organization.update', $organization->id), 'method' => 'PATCH', 'files' => 'true']) !!}

		<table class="form-table">
			<tr>
				<td>{!! Form::label('name', 'Organization') !!}</td>
				<td>{!! Form::text('name', $organization->name, ['placeholder' => 'Valve', 'class' => 'form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('url', 'Website') !!}</td>
				<td>{!! Form::text('url', $organization->url, ['placeholder' => 'http://site.com', 'class' => 'form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('logo', 'Logo') !!}</td>
				<td>{!! Form::file('logo') !!}</td>
			</tr>

			<tr>
				<td></td>
				<td>{!! Form::submit('Save changes', ['class' => 'btn btn-primary']) !!}</td>
			</tr>

		</table>


		{!! Form::close() !!}
	</div>
@endsection



