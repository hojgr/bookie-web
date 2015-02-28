<?php namespace BookieGG\Models\Csgo;

use Illuminate\Database\Eloquent\Model;

class CsgoItemPrice extends Model {

	public function csgo_item_skin() {
		return $this->belongsTo('BookieGG\Models\Csgo\CsgoItemPrice');
	}

	public function exterior() {
		return $this->hasOne('BookieGG\Models\Csgo\CsgoItemExterior');
	}

}
