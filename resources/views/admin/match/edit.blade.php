@extends('admin/app')

@section('content')
	<div class="content-box">
		<h2>Edit a match [{!! LogoUtil::render($match->teams[0]) !!} vs. {!! LogoUtil::render($match->teams[1]) !!}]</h2>

		<ul class="validation">
			@foreach($errors->all() as $error)
				<li class="error">{{ $error }}</li>
			@endforeach
		</ul>

		{!! Form::open(['url' => route('admin.match.update', $match->id), 'method' => 'PATCH']) !!}

		<table class="form-table">
			<tr>
				<td>{!! Form::label('bo', 'Style') !!}</td>
				<td>
					{!! Form::select('bo', $all_bos, $match->bo, ['class' => 'selectpicker']) !!}
				</td>
			</tr>
			<tr class="ignore-a-css">
				<td>{!! Form::label('start', 'Start') !!}</td>
				<td style="position: relative">
					{!! Form::text('start', null, ['class' => 'timepicker form-control']) !!}
					<small>note: leave empty if you don't want to change it</small>
				</td>
			</tr>
			<tr class="ignore-a-css">
				<td>{!! Form::label('note', 'Note') !!}</td>
				<td style="position: relative">
					{!! Form::text('note', $match->note ? $match->note->note : '', ['placeholder' => 'A note for a match', 'class' => 'form-control']) !!}
				</td>
			</tr>

			<tr>
				<td></td>
				<td>{!! Form::submit('Edit match', ['class' => 'btn btn-primary']) !!}</td>
			</tr>

		</table>


		{!! Form::close() !!}
		<script>
			$(document).ready(function() {
				$('.selectpicker').selectpicker();
				$('.timepicker').datetimepicker();
			});
		</script>
	</div>
@endsection



