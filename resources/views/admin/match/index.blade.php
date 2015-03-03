@extends('admin/app')

@section('content')
	<div class="content-box" style="width: 940px">
		<h2>All matches <a href="{{ route('admin.match.create') }}" class="btn btn-primary">Add</a></h2>

		<table class="table vertical">
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th style="text-align: center">Host</th>
				<th>BO#</th>
				<th>Starts</th>
				<th></th>
				<th></th>
			</tr>
			@foreach($matches as $m)
				<tr>
					<td style="text-align: right; @if($m->winner_id != 0 and $m->teams[0]->id != $m->winner_id) opacity: 0.3 @endif">
						<b>{{ $m->teams[0]->short_name }}</b>
						{!! LogoUtil::render($m->teams[0]) !!}
					</td>
					<td>
						vs.
					</td>
					<td style="@if($m->winner_id != 0 and $m->teams[1]->id != $m->winner_id) opacity: 0.3 @endif">
						{!! LogoUtil::render($m->teams[1]) !!}
						<b>{{ $m->teams[1]->short_name }}</b>
					</td>
					<td style="text-align: center">{{ $m->organization->name }}</td>
					<td>BO{{ $m->bo }}</td>
					<td>{{ $m->start }}</td>
					<td><a class="btn btn-primary" href="{{ route('admin.match.edit', $m->id) }}">Edit!</a></td>
					<td>
						@if($m->winner_id == 0)
							<div class="btn-group">
								<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									Pick a winner <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a onclick="if(confirm('Did \'{{ $m->teams[0]->name }}\' actually win against \'{{ $m->teams[1]->name }}\'?')) { window.location = '{{ route('admin.match.pickwinner', [$m->id, $m->teams[0]->id]) }}'; }" href="javascript:void(0)">
											{{ $m->teams[0]->name }}
										</a>
									</li>
									<li>
										<a onclick="if(confirm('Did \'{{ $m->teams[1]->name }}\' actually win against \'{{ $m->teams[0]->name }}\'?')) { window.location = '{{ route('admin.match.pickwinner', [$m->id, $m->teams[1]->id]) }}'; }" href="javascript:void(0)">
											{{ $m->teams[1]->name }}
										</a>
									</li>
								</ul>
							</div>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection