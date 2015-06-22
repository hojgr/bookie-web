<?php


namespace BookieGG\Traits;


trait HasLogo {
    public function images() {
        return $this->hasOne(get_class() . 'Image');
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