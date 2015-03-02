<?php namespace BookieGG\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model {
	public function teams() {
		return $this->belongsToMany('BookieGG\Models\Team');
	}

	public function organization() {
		return $this->belongsTo('BookieGG\Models\Organization');
	}

	public function getStartDateAttribute()
	{
		return Carbon::parse($this->start);
	}
}
