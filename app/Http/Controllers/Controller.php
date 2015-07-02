<?php namespace BookieGG\Http\Controllers;

use BookieGG\Contracts\Repositories\ArticleRepositoryInterface;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use BookieGG\Services\PopupManager;

abstract class Controller extends BaseController {

    use DispatchesCommands, ValidatesRequests;

    public function __construct(
        ArticleRepositoryInterface $ari,
        PopupManager $popupManager
    ) {
        // TODO: move to separate class ( http://laravel.com/docs/5.0/views#view-composers )
        \View::composer('app', function($v) use ($ari, $popupManager) {
            $v->with('articles', $ari->all());
            $v->with('isPopupActive', $popupManager->hasActivePopup(auth()->getUser()));
        });
    }
}
