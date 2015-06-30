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
        return view('popup/active');
    }
}
