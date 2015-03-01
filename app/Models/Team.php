<?php namespace BookieGG\Models;

use BookieGG\Traits\HasLogo;
use Illuminate\Database\Eloquent\Model;

class Team extends Model {

	use HasLogo;

	public function match() {
		$this->belongsToMany('BookieGG\Models\Match');
	}

}
