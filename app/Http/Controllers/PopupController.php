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
use BookieGG\Services\RedisTrades;

class PopupController extends Controller
{
    /**
     * Returns active popup
     *
     * @param UserTradeRepository $tradeRepo    Trade repo
     * @param TradeManager        $tradeManager Trade manager
     *
     * @return json
     */
    public function getActive(
        UserTradeRepository $tradeRepo,
        TradeManager $tradeManager
    ) {
        $userTrade = $tradeManager->syncUser(auth()->getUser());

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
                              ->with('data', ['bot' => $userTrade->bot->display_name,
                                              'code' => '1AS2',
                                              'time-left' => (strtotime($userTrade->created_at) + 4 * 60) - time(),
                                              'url' => $userTrade->getTradeURL()])
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
                    'success' => true,
                    'destroy' => 1000,
                    'refresh' => 1000
                ]
            );
        } elseif ($userTrade->status == TradeManager::STATUS_CANCELLED) {
            return response()->json(
                [
                    'html' => view('popup/active')
                              ->with('state', 'cancelled')
                              ->render(),
                    'success' => true,
                    'destroy' => 5000
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
