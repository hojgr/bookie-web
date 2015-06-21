<?php


namespace BookieGG\Models;


use Illuminate\Database\Eloquent\Model;

class CsgoItemPrice extends Model {
	public function item() {
		return $this->belongsTo('BookieGG\Models\CsgoItem');
	}
}