<?php


namespace BookieGG\Contracts;


interface Authenticatable {
    public function authenticate();
    public function process();
    public function isAuthenticated();
    public function getUser();
    public function logout();
}