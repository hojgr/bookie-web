<?php


namespace BookieGG\Facades;


use Illuminate\Support\Facades\Facade;

class LogoUtil extends Facade {
    protected static function getFacadeAccessor() {
        return 'BookieGG\Contracts\LogoUtilityInterface';
    }
}