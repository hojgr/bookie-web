<div class="itembox small {{ strtolower($item->quality) }} tipped">
	@foreach($item as $k=>$v)
		@if($k != "steam_info")
			<input type="hidden" name="{{ $k }}" value="{{ $v }}" />
		@endif
		@if($k == "steam_info")
			<input type="hidden" name="{{ $k }}" value="
			@foreach($v as $v)
				{{$v}},
			@endforeach
			" />
		@endif
	@endforeach
	@if(isset($item->steam_info))
		@foreach($item->steam_info as $n=>$v)
			<input type="hidden" name="items[{{ $item->id }}][{{ $n }}]" value="{{ $v }}">
		@endforeach
	@else
		<input type="hidden" name="items[]" value="{{ $item->id }}" />
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
		<img alt="{{ $item->weaponName }}" class="item-img" src="{{ $item->image }}" />
		<div class="text-content text-center">
			<h4>{{ $item->weaponName }}
			@if($item->stattrak)
				<span class="tipped">(ST)<div class="tip">This item has stattrack technology</div></span>
			@endif</h4>
			<p>{{ $item->quality }}</p>
		</div>
	</div>
</div>
