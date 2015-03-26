@extends('app')


{{-- */ $userBank = []; $x = rand(1,20); for($i=0; $i<$x;$i++) { $userBank[] = $weapons[rand(0, count($weapons)-1)]; } /*--}}
{{-- */ $userInventory = []; $x = rand(1,20); for($i=0; $i<$x;$i++) { $userInventory[] = $weapons[rand(0, count($weapons)-1)]; } /*--}}

@section('content')
<div class="column">
	<div class="module bank-module">
		<h1>My Bank</h1>
		<h3 class="subheader">You currently have the following items stored on <em>Bookie.GG</em>:</h3>
		@include('partials/inventory', ['items' => $userBank])
	</div>
</div>
<div class="column">
	<div class="module inventory-module">
		<h1>My Inventory</h1>
		<h3 class="subheader">Your Steam inventory:
		@include('partials/inventory', ['items' => $userInventory])
	</div>
</div>
@endsection