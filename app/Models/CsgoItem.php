<?php


namespace BookieGG\Models;


use Illuminate\Database\Eloquent\Model;

class CsgoItem extends Model {

    public function csgo_item_prices() {
        return $this->hasMany('BookieGG\Models\CsgoItemPrice');
    }

    public function latestPrice() {
        return $this->hasOne('BookieGG\Models\CsgoItemPrice')->latest();
    }

    public function csgo_item_quality() {
        return $this->belongsTo("BookieGG\\Models\\CsgoItemQuality");
    }

    public function csgo_item_exterior() {
        return $this->belongsTo('BookieGG\Models\CsgoItemExterior');
    }

    public function user_banks() {
        return $this->hasMany("BookieGG\\Models\\UserBank");
    }

    public function getLogoURL() {
        return "http://steamcommunity-a.akamaihd.net/economy/image/" . $this->logo . "/90fx60f";
    }

    public function getLargeLogoURL() {
        return "http://steamcommunity-a.akamaihd.net/economy/image/" . $this->logo . "/512fx512f";
    }
}
