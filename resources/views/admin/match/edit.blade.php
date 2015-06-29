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
				<td>Teams</td>
				<td>
					{!! Form::select('t1', $teams, $match->teams[0]->id, ['class' => 'selectpicker', 'data-live-search' => "true"]) !!}
					vs.
					{!! Form::select('t2', $teams, $match->teams[1]->id, ['class' => 'selectpicker', 'data-live-search' => "true"]) !!}
				</td>
			</tr>
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
					{!! Form::text('note', $match->note ? $match->note->note : '', ['placeholder' => 'A note for a match', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
				</td>
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
				<td>{!! Form::submit('Edit match', ['class' => 'btn btn-primary']) !!}</td>
			</tr>

		</table>


		{!! Form::close() !!}
		<script>
			$(document).ready(function() {
				$('.selectpicker').selectpicker();
				$('.timepicker').datetimepicker();

				function format(inp) {

					inp = inp.replace(/\*(.*?)\*/g, "<b>$1</b>");
					inp = inp.replace(/_(.*?)_/g, "<i>$1</i>");
					inp = inp.replace(/<red>(.*?)<\/red>/g, "<span style='color: red'>$1</span>");
					inp = inp.replace(/<green>(.*?)<\/green>/g, "<span style='color: green'>$1</span>");
					inp = inp.replace(/<blue>(.*?)<\/blue>/g, "<span style='color: #02a4d9'>$1</span>");

					return inp;
				}

				var input = $('input[name=note]');

				function len(inp) {
					inp = inp.replace(/\*(.*?)\*/g, "$1");
					inp = inp.replace(/_(.*?)_/g, "$1");
					inp = inp.replace(/<red>(.*?)<\/red>/g, "$1");
					inp = inp.replace(/<green>(.*?)<\/green>/g, "$1");
					inp = inp.replace(/<blue>(.*?)<\/blue>/g, "$1");

					return inp.length;
				}


				$('.note-preview').html(format(input.val()));

				input.keyup(function() {
					var note = format(input.val());

					var l = len(input.val());

					if(l > 60) {
						$('.warning').html("<span style='color: red; font-weight: bold'>The note is too long! " + l + "/60");
					} else {
						$('.warning').html(l + "/60");
						console.log("doesnt work");
					}
					$('.note-preview').html(note);
				});
			});
		</script>
	</div>
@endsection



