<?php namespace BookieGG\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model {
	public function teams() {
		return $this->belongsToMany('BookieGG\Models\Team');
	}

	public function organization() {
		$this->belongsTo('BookieGG\Models\Organization');
	}
}
