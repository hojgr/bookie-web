<?php namespace BookieGG\Models\Csgo;

use Illuminate\Database\Eloquent\Model;

class CsgoItem extends Model {

	function skins() {
		return $this->hasMany('BookieGG\Models\Csgo\CsgoItemSkin');
	}

}
