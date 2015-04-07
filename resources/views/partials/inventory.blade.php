{{--*/ if(!isset($btns)) { $btns=["Withdraw" => "withdrawItems()"]; } /*--}}
{{--*/ if(!isset($submitUrl)) { $submitUrl = "/"; } /*--}}
{{--*/ if(!isset($emptyText)) { $emptyText = "Select items to bet"; } /*--}}

<div class="inventory">
	@if(isset($submitUrl))
	{!! Form::open(array('url' => $submitUrl, 'class' => 'inventory-selection')) !!}
		<div class="item-holder flex-wrap flex-start" data-if-empty="{{ $emptyText }}"></div><!--
		--><div class="btn-holder">
			{{--*/ $i = -1; /*--}}
			@foreach($btns as $b=>$s)
				{{--*/ $i++; $buttonOpts = ['disabled' => 'true', 'class' => 'btn-primary btn-wide', 'type' => 'submit', 'name' => 'team', 'value' => isset($btnVal) ? $btnVal : $i]; if (!empty($s)) { $buttonOpts['onclick'] = $s; } /*--}}
				{!! Form::button($b, $buttonOpts) !!}
			@endforeach
		</div>
	{!! Form::close() !!}
	@endif
	
	<div class="inventory-holder item-holder flex-wrap">
	@foreach($items as $url)
		@include('partials/small_item', ['wep_img' => $url])
	@endforeach
	</div>
</div>