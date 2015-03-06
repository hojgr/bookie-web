<?php namespace BookieGG\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model {

	const STATUS_NOT_FINISHED = 0;
	const STATUS_FINISHED = 1;

	public function teams() {
		return $this->belongsToMany('BookieGG\Models\Team');
	}

	public function note() {
		return $this->hasOne('BookieGG\Models\MatchNote');
	}

	public function organization() {
		return $this->belongsTo('BookieGG\Models\Organization');
	}

	public function getStartDateAttribute()
	{
		return Carbon::parse($this->start);
	}
}
