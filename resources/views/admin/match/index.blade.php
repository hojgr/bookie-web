@extends('admin/app')

@section('content')
	<div class="content-box" style="width: 940px">
		<h2>All matches <a href="{{ route('admin.match.create') }}" class="btn btn-primary">Add</a></h2>

		<table class="table vertical">
			<tr>
				<th>vs.</th>
				<th>BO#</th>
				<th>Starts</th>
			</tr>
			@foreach($matches as $m)
				<tr>
					<td>
						{!! LogoUtil::render($m->teams[0]) !!}
						<b>{{ $m->teams[0]->name }}</b>
						vs.
						<b>{{ $m->teams[1]->name }}</b>
						{!! LogoUtil::render($m->teams[1]) !!}
					</td>
					<td>BO{{ $m->bo }}</td>
					<td>{{ $m->start }}</td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection