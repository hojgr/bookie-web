<?php


namespace BookieGG\Models;


use Illuminate\Database\Eloquent\Model;

class CsgoItemPrice extends Model {
    public function csgo_item() {
        return $this->belongsTo('BookieGG\Models\CsgoItem');
    }
}