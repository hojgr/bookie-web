<?php namespace BookieGG\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

	public function user() {
		return $this->belongsTo('BookieGG\Models\User');
	}

}
