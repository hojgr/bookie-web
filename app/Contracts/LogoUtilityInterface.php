<?php


namespace BookieGG\Contracts;


interface LogoUtilityInterface {
    public function render($thing);
    public function renderSpecial($thing, $size);
}