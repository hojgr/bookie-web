@extends('admin/app')

@section('content')
	<div class="content-box">
		<h2>Edit team [{{ $team->name }}]</h2>

		<ul class="validation">
			@foreach($errors->all() as $error)
				<li class="error">{{ $error }}</li>
			@endforeach
		</ul>

		{!! Form::open(['url' => route('admin.team.update', $team->id), 'files' => 'true', 'method' => 'PUT']) !!}

		<table class="form-table">
			<tr>
				<td>{!! Form::label('name', 'Team') !!}</td>
				<td>{!! Form::text('name', $team->name, ['placeholder' => 'Teb\'s team', 'class' => 'form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('shortname', 'Short name') !!}</td>
				<td>{!! Form::text('shortname', $team->short_name, ['placeholder' => 'Leave empty if it\'s the same as name', 'class' => 'form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('logo', 'Logo') !!}</td>
				<td>{!! Form::file('logo') !!}</td>
			</tr>

			<tr>
				<td></td>
				<td>{!! Form::submit('Edit team', ['class' => 'btn btn-primary']) !!}</td>
			</tr>

		</table>


		{!! Form::close() !!}
	</div>
@endsection



