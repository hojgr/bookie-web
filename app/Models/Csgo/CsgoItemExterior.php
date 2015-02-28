<?php namespace BookieGG\Models\Csgo;

use Illuminate\Database\Eloquent\Model;

class CsgoItemExterior extends Model {

	public function prices() {
		return $this->belongsToMany('BookieGG\Models\Csgo\CsgoItemPrice');
	}

}
