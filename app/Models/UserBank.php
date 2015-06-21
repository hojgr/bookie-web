<?php


namespace BookieGG\Models;


use Illuminate\Database\Eloquent\Model;

class UserBank  extends Model {
	public function user() {
		return $this->belongsTo("BookieGG\\Models\\User");
	}

	public function csgo_item() {
		return $this->belongsTo("BookieGG\\Models\\CsgoItem");
	}
}