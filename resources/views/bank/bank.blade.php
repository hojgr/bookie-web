{{--
 * A view for main bank page
 *
 * PHP version 5.6
 *
 * @category View
 * @package  Bank
 * @author   Johan Fagerberg <now@known.com>
 * @license  MS Reference
 * @link     http://bookie.gg
--}} 
{{-- */ $wideLayout=true; /*--}}
@extends('app')

@section('content')
<div class="column small-medium">
	<div class="module bank-module">
		<h2>My Bank</h2>
        @include(
            'partials/inventory',
            [
                'submitUrl' => '/api/csgo/bank/withdraw',
                'items' => $userBank,
                'btns' => ['Withdraw' => ''],
                'emptyText' => 'Select items to withdraw'
            ]
        )
	</div>
</div>
<div class="column small-medium">
	<div class="module inventory-module">
		<h2>My Inventory</h2>
        @include(
            'partials/inventory', 
            [
                'submitUrl' => '/api/csgo/bank/deposit',
                'items' => $userInventory,
                'btns' => ['Deposit' => ''],
                'emptyText' => 'Select items to deposit'
            ]
        )
	</div>
</div>
@endsection
