@extends('admin/app')

@section('content')
	<div class="content-box">
		<h2>Add a match</h2>

		<ul class="validation">
			@foreach($errors->all() as $error)
				<li class="error">{{ $error }}</li>
			@endforeach
		</ul>

		{!! Form::open(['route' => 'admin.match.store']) !!}

		<table class="form-table">
			<tr>
				<td>{!! Form::label('organizer', 'Organization') !!}</td>
				<td>{!! Form::select('organizer', $organizers, null, ['class' => 'selectpicker', 'data-live-search' => "true"]) !!}</td>
			</tr>
			<tr>
				<td>Teams</td>
				<td>
					{!! Form::select('t1', $teams, null, ['class' => 'selectpicker', 'data-live-search' => "true"]) !!}
					vs.
					{!! Form::select('t2', $teams, null, ['class' => 'selectpicker', 'data-live-search' => "true"]) !!}
				</td>
			</tr>

			<tr>
				<td>{!! Form::label('bo', 'Style') !!}</td>
				<td>
					{!! Form::select('bo', $all_bos, null, ['class' => 'selectpicker']) !!}
				</td>
			</tr>
			<tr class="ignore-a-css">
				<td>{!! Form::label('start', 'Start') !!}</td>
				<td style="position: relative">{!! Form::text('start', null, ['class' => 'timepicker form-control']) !!}</td>
			</tr>
			<tr>
				<td>{!! Form::label('note', 'Note') !!}</td>
				<td style="position: relative">{!! Form::text('note', null, ['placeholder' => 'Note for a match', 'class' => 'form-control']) !!}</td>
			</tr>

			<tr>
				<td>Preview</td>
				<td class="note-preview"></td>
			</tr>
			<tr>
				<td></td>
				<td class="warning"></td>
			</tr>

			<tr>
				<td></td>
				<td>{!! Form::submit('Add match', ['class' => 'btn btn-primary']) !!}</td>
			</tr>

		</table>


		{!! Form::close() !!}
		<script>
			$(document).ready(function() {
				$('.selectpicker').selectpicker();
				$('.timepicker').datetimepicker();
			});

			function format(inp) {

				inp = inp.replace(/\*([^\*]+)\*/g, "<b>$1</b>");
				inp = inp.replace(/_([^_]+)_/g, "<i>$1</i>");

				return inp;
			}

			$('input[name=note]').keyup(function() {
				var note = format($('input[name=note]').val());

				$('.note-preview').html(note);
			});
		</script>
	</div>
@endsection



