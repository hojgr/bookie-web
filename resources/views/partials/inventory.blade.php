{{--*/ if(!isset($btns)) { $btns = ['asd']; } /*--}}
<div class="inventory" data-bound-buttons="{{ join(', ', $btns) }}">
	<div class="item-list">
	@foreach($items as $url)
		@include('partials/small_item', ['wep_img' => $url])
	@endforeach
	</div>
</div>