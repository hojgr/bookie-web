@extends('admin/app')

@section('content')
	<div class="content-box" style="width: 940px">
		<h2>All teams <a class='btn btn-primary' href="{{ route('admin.team.create') }}">Add</a></h2>
		<br />
		<table class="table table-middle">
			<tr>
				<th>Logo</th>
				<th>Name</th>
				<th></th>
			</tr>
			@foreach($teams as $t)
			<tr>
				<td>{!! LogoUtil::render($t) !!}</td>
				<td>
					{{ $t->name }}
					@if($t->name != $t->short_name)
						({{ $t->short_name }})
					@endif
				</td>
				<td><a class="btn btn-info" href="{{ route('admin.team.edit', $t->id) }}">edit</a></td>
			</tr>
			@endforeach
		</table>

	</div>
@endsection



