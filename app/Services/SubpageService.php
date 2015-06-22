<?php


namespace BookieGG\Services;


use BookieGG\Contracts\Repositories\SubpageRepositoryInterface;
use BookieGG\Contracts\SubpageServiceInterface;

class SubpageService implements SubpageServiceInterface {
    /**
     * @var SubpageRepositoryInterface
     */
    private $sri;

    /**
     * @param SubpageRepositoryInterface $sri
     */
    public function __construct(SubpageRepositoryInterface $sri) {

        $this->sri = $sri;
    }

    public function getPage($name) {
        return $this->sri->get($name);
    }
}