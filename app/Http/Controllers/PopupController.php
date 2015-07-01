<?php
/**
 * Manages popups
 *
 * PHP version 5.6
 *
 * @category Class
 * @package  BookieGG\Http\Controllers
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */

namespace BookieGG\Http\Controllers;

class PopupController extends Controller {
    public function getActive() {
        // returns json
        /*return response()->json(
            [
                'ignore' => true
            ]
        );*/

        /*return response()->json([
        		'html' => view('popup/active')
                          ->with('state', 'queue')
                          ->with('data', ['place' => 24])
                          ->render(),
                'success' => true
			]);*/

        return response()->json([
        		'html' => view('popup/active')
                          ->with('state', 'offer')
                          ->with('data', ['bot' => 'Bookkeeper Banana',
                          	              'code' => '1AS2',
                          	              'time-left' => 25,
                          	              'url' => 'http://google.com'])
                          ->render(),
                'success' => true
			]);
    }
}
