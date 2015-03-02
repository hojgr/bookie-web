@extends('admin/app')

@section('content')
	<div class="content-box" style="width: 940px">
		<h2>All organizations <a class='btn btn-primary' href="{{ route('admin.organization.create') }}">Add</a></h2>
		<br />
		<table class="table table-middle" >
			<tr>
				<th>Logo</th>
				<th>Name</th>
				<th>Site</th>
				<th></th>
			</tr>
			@foreach($organizations as $o)
			<tr>
				<td>{!! LogoUtil::render($o) !!}</td>
				<td>{{ $o->name }}</td>
				<td><a href="{{$o->url}}">{{ $o->url }}</a></td>
				<td><a class="btn btn-info" href="{{ route('admin.organization.edit', $o->id) }}">edit</a></td>
			</tr>
			@endforeach
		</table>

	</div>
@endsection



