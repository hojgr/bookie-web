{{-- */ $wideLayout=true; /*--}}
@extends('app')

{{-- */ $userBank = []; $x = rand(1,20); for($i=0; $i<$x;$i++) { $userBank[] = $weapons[rand(0, count($weapons)-1)]; } /*--}}
{{-- */ $userInventory = []; $x = rand(1,20); for($i=0; $i<$x;$i++) { $userInventory[] = $weapons[rand(0, count($weapons)-1)]; } /*--}}

@section('content')
<div class="column small-medium">
	<div class="module bank-module">
		<h2>My Bank</h2>
		@include('partials/inventory', ['items' => $userBank, 'btns' => ['Withdraw' => 'withdrawItems()'], 'emptyText' => 'Select items to withdraw'])
	</div>
</div>
<div class="column small-medium">
	<div class="module inventory-module">
		<h2>My Inventory</h2>
		@include('partials/inventory', ['items' => $userInventory, 'btns' => ['Deposit' => 'depositItems()'], 'emptyText' => 'Select items to deposit'])
	</div>
</div>
@endsection