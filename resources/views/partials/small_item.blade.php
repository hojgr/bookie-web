<div class="itembox small {{ strtolower($item->quality) }} tipped">
	@if(isset($item->steam_info))
		@foreach($item->steam_info as $n=>$v)
			<input type="hidden" name="item[{{ $item->id }}][{{ $n }}]" value="{{ $v }}">
		@endforeach
	@else
		<input type="hidden" name="item[]" value="{{ $item->id }}" />
	@endif
	<div class="itembox-header">
		@if($item->stattrak)
		<div class="item-stattrak">ST</div>
		<div class="seperator">|</div>
		@endif
		<div class="item-price">{{ $item->price }}</div>
	</div>

	<img alt="CS:GO weapon" class="item-img" src="{{ $item->image }}" />

	<div class="itembox-footer">
		<div class="item-exterior">{{ $item->exterior }}</div>
		<div class="item-quality">{{ $item->quality }}</div>
	</div>

	<div class="tip">
		<span>Text goes here.</span><br />
		<span>Some more text.</span>
	</div>
</div>