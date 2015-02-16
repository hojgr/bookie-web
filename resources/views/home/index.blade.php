@extends('app')

@section('content')
    index page<br />
    @if(Auth::check())
        Username: {{ Auth::user()->display_name }}
    @else
        Not logged in
    @endif
@endsection
