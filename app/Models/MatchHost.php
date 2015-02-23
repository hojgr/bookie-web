<?php namespace BookieGG\Models;

use Illuminate\Database\Eloquent\Model;

class MatchHost extends Model {

	protected $fillable = ['name', 'url'];

	public function matches() {
		return $this->hasMany('BookieGG\Models\Match');
	}
}
