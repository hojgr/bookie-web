<?php namespace BookieGG\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationImage extends Model {

	public function image_type() {
		return $this->belongsTo('BookieGG\Models\ImageType');
	}

}
