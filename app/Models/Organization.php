<?php namespace BookieGG\Models;

use BookieGG\Traits\HasLogo;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model {

    use HasLogo;

    protected $fillable = ['name', 'url'];

    public function matches() {
        return $this->hasMany('BookieGG\Models\Match');
    }
}
