<?php namespace BookieGG\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model {

	protected $fillable = ['name', 'url'];

	public function matches() {
		return $this->hasMany('BookieGG\Models\Match');
	}
}
