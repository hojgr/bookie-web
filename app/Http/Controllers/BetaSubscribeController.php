<?php


namespace BookieGG\Http\Controllers;


use BookieGG\Commands\SubscribeUserToBeta;
use BookieGG\Http\Requests\SubscribeFormRequest;

class BetaSubscribeController extends Controller {

    /**
     * @param SubscribeFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(SubscribeFormRequest $request) {
        $this->dispatch(new SubscribeUserToBeta(\Auth::user(), $request->input()));
        return \Redirect::route('beta_home');
    }
}