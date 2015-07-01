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

use BookieGG\Repositories\Eloquent\UserTradeRepository;
use BookieGG\Services\TradeManager;

class PopupController extends Controller
{
    /**
     * Returns active popup
     *
     * @param UserTradeRepository $tradeRepo Trade repo
     *
     * @return json
     */
    public function getActive(UserTradeRepository $tradeRepo)
    {
        $userTrade = auth()->getUser()->user_last_trade;

        if ($userTrade->status == TradeManager::STATUS_QUEUE) {
            return response()->json(
                [
                    'html' => view('popup/active')
                              ->with('state', 'queue')
                              ->with('data', ['place' => $tradeRepo->getQueuePosition(auth()->getUser())])
                              ->render(),
                    'success' => true
                ]
            );
        } elseif ($userTrade->status == TradeManager::STATUS_ACTIVE) {
            return response()->json(
                [
                    'html' => view('popup/active')
                              ->with('state', 'offer')
                              ->with('data', ['bot' => 'Bookkeeper Banana',
                                              'code' => '1AS2',
                                              'time-left' => (strtotime($userTrade->created_at) + 4 * 60) - time(),
                                              'url' => 'http://google.com'])
                              ->render(),
                    'success' => true
                ]
            );
        } elseif ($userTrade->status == TradeManager::STATUS_ACCEPTED) {
            return response()->json(
                [
                    'html' => view('popup/active')
                              ->with('state', 'accepted')
                              ->render(),
                    'success' => true
                ]
            );
        } elseif ($userTrade->status == TradeManager::STATUS_CANCELLED) {
            return response()->json(
                [
                    'html' => view('popup/active')
                              ->with('state', 'cancelled')
                              ->render(),
                    'success' => true
                ]
            );
        }

        return response()->json(
            [
                'destroy' => true
            ]
        );
    }
}
