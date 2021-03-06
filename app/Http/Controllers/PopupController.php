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
                                              'time-left' => ($userTrade->getCreatedAtTimestamp() + 4 * 60) - time(),
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
                    'popupType' => 'success',
                    'destroy' => 1000,
                    'refresh' => 1000
                ]
            );
        } elseif (false) {
       
        } elseif ($userTrade->status == TradeManager::STATUS_CANCELLED) {
            return response()->json(
                [
                    'html' => view('popup/active')
                              ->with('state', 'cancelled')
                              ->render(),
                    'success' => true,
                    'popupType' => 'error',
                    'inventories' => true,
                    'destroy' => 5000
                ]
            );
        }

        return response()->json(
            [
                'destroy' => true,
                'success' => false,
            ]
        );
    }
}
