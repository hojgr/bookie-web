<?php


namespace BookieGG\Models;


use Illuminate\Database\Eloquent\Model;

class CsgoItem extends Model {

	public function prices() {
		return $this->hasMany('BookieGG\Models\CsgoItemPrice');
	}
}