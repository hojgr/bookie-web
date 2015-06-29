@extends('admin/app')

@section('content')
	<div class="content-box">
		<h2>Add team</h2>

		<ul class="validation">
			@foreach($errors->all() as $error)
				<li class="error">{{ $error }}</li>
			@endforeach
		</ul>

		{!! Form::open(['route' => 'admin.team.store', 'files' => 'true']) !!}

		<table class="form-table">
			<tr>
				<td>{!! Form::label('name', 'Team') !!}</td>
				<td>{!! Form::text('name', null, ['placeholder' => 'Teb\'s team', 'class' => 'form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('shortname', 'Short name') !!}</td>
				<td>{!! Form::text('shortname', null, ['placeholder' => 'Leave empty if it\'s the same as name', 'class' => 'form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('logo', 'Logo') !!}</td>
				<td>{!! Form::file('logo') !!}</td>
			</tr>

			<tr>
				<td></td>
				<td>{!! Form::submit('Add new team', ['class' => 'btn btn-primary']) !!}</td>
			</tr>

		</table>


		{!! Form::close() !!}
	</div>
@endsection



