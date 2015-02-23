<?php namespace BookieGG\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model {

	public function match() {
		$this->belongsToMany('BookieGG\Models\Match');
	}

}
