<?php namespace BookieGG\Models\Csgo;

use Illuminate\Database\Eloquent\Model;

class CsgoItemSkin extends Model {

	public function csgo_item() {
		return $this->belongsTo('BookieGG\Models\Csgo\CsgoItem');
	}

	public function prices() {
		return $this->hasMany('BookieGG\Models\Csgo\CsgoItemPrice');
	}
}
