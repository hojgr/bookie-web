{{--*/ if(!isset($emptyText)) { $emptyText = "Select items to bet"; } /*--}}
{{--*/ if(!isset($selected)) { $selected = []; }/*--}}
{{--*/ if(!isset($disable)) { $disable = false; }/*--}}

<div class="inventory @if($disable)disabled @endif">
	@if(isset($submitUrl))
	{!! Form::open(array('url' => $submitUrl, 'class' => 'inventory-selection no-style')) !!}
		@spaceless
		@if(isset($data))
			@foreach($data as $n=>$v)
				{!! Form::hidden($n, $v) !!}
			@endforeach
		@endif
		<div class="item-holder" data-if-empty="{{ $emptyText }}">
			@if(isset($selected))
				@foreach($selected as $item)
					@include('partials/small_item', ['item' => $item])
				@endforeach
			@endif
		</div>
		<div class="btn-holder">
			{{--*/ $i = -1; /*--}}
			@foreach($btns as $b=>$s)
				{{--*/ $i++; $buttonOpts = ['disabled' => 'true', 'class' => 'btn-primary btn-wide', 'type' => 'submit']; /*--}}
				{{--*/ if(isset($submitTeam) && $submitTeam) { $buttonOpts['name'] = 'team'; $buttonOpts['value'] = isset($btnVal) ? $btnVal : $i; } /*--}}
				{!! Form::button($b, $buttonOpts) !!}
			@endforeach
		</div>
		@endspaceless
	{!! Form::close() !!}
	@endif
	
	<div class="inventory-ui">
		<i class="dir asc"></i>
		<span>Sort: </span>
		<i class="tipped value active">attach_money
			<div class="tip">Value</div>
		</i>
		<i class="tipped quality">star
			<div class="tip">Quality</div>
		</i>
		<span class="splitter"></span>
		<span>Filter: </span>
		<i class="tipped stattrak">ST
			<div class="tip">StatTrak</div>
		</i>
		<i class="tipped stickers">crop_original
			<div class="tip">Stickers</div>
		</i>
		<i class="tipped misc">vpn_key
			<div class="tip">Misc</div>
		</i>

		<div class="input-group">
			<input type="search" placeholder="Search">
			<div class="focus-indicator"></div>
		</div>
	</div>

	<div class="inventory-holder item-holder">
	@spaceless
	@foreach($items as $item)
		@if(!in_array($item, $selected))
			@include('partials/small_item', ['item' => $item])
		@endif
	@endforeach
	@endspaceless
	</div>
</div>
