<div class="inventory">
	<div class="item-list">
	@foreach($items as $url)
		@include('partials/small_item', ['wep_img' => $url])
	@endforeach
	</div>
</div>