<?php namespace BookieGG\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model {

	protected $fillable = ['name', 'url'];

	public function matches() {
		return $this->hasMany('BookieGG\Models\Match');
	}

	public function images() {
		return $this->hasOne('BookieGG\Models\OrganizationImage');
	}

	public function getLogo() {

		if(count($this->images)) {
			return $this->images()->whereHas('image_type', function($q) {
				$q->where('type', '=', 'logo');
			})->firstOrFail();
		}

		return null;
	}
}
