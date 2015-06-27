<?php
/**
 * BankController
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

use BookieGG\Models\CsgoItem;
use BookieGG\Models\CsgoItemPrice;
use BookieGG\Repositories\Eloquent\BankRepository;
use BookieGG\Contracts\InventoryLoaderInterface;
use BookieGG\Contracts\BankLoaderInterface;
use BookieGG\Services\ItemUtility;
use \Illuminate\Auth\Guard;
use \Illuminate\Http\Response;
use \Illuminate\Http\Request;
use BookieGG\Commands\DepositItemsCommand;
use BookieGG\Repositories\Eloquent\UserTradeRepository;

/**
 * BankController
 *
 * @category Class
 * @package  BookieGG\Http\Controllers
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
class BankController extends Controller
{
    /**
     * Shows user's bank
     *
     * @param InventoryLoaderInterface $inventoryLoader Handles inventory loading
     * @param BankLoaderInterface      $bankLoader      Handles bank loading
     * @param Guard                    $guard           Guards user
     * @param UserTradeRepository      $tradeRepo       User trade repository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(
        InventoryLoaderInterface $inventoryLoader,
        BankLoaderInterface $bankLoader,
        Guard $guard,
        UserTradeRepository $tradeRepo
    ) {
        $inventory = $inventoryLoader->loadSteamInventory(
            $guard->getUser()->steam_id
        );

        $bank = $bankLoader->load($guard->getUser());

        list($pendingDeposit, $pendingWithdraw) = $tradeRepo->getPendingTrade($guard->getUser());

        return view("bank/bank")
            ->with('userInventory', $inventory)
            ->with('userBank', $bank)
            ->with('pendingDeposit', $pendingDeposit)
            ->with('pendingWithdraw', $pendingWithdraw);
    }

    /**
     * Initiates an operation for moving items from
     * user's steam inventory to our bot's inventory
     *
     * @param Request             $request   HTTP Request
     * @param UserTradeRepository $tradeRepo A trade repo
     *
     * @see http://docs.bookiegg.apiary.io/#reference/betting-api/make-bet
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deposit(
        Request $request,
        UserTradeRepository $tradeRepo
    ) {
        list(
            $pendingDeposit,
            $pendingWithdraw
        ) = $tradeRepo->getPendingTrade(auth()->getUser());
        if (count($pendingDeposit) != 0
            || count($pendingWithdraw) != 0
        ) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'You already have one trade pending!'
                ]
            );
        }

        $items = $request->input('items');

        $this->dispatch(
            new DepositItemsCommand(
                auth()->getUser(),
                $items
            )
        );

        return response()->json(
            [
                'success' => true,
                'message' => 'You are in a queue waiting for available bot!'
            ]
        );
    }

    /**
     * Initiates an operation for moving items from
     * user's bank (bot) to his inventory
     *
     * @param Request             $request   HTTP Request
     * @param UserTradeRepository $tradeRepo A trade repo
     *
     * @see http://docs.bookiegg.apiary.io/#reference/betting-api/make-bet
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function withdraw(
        Request $request,
        UserTradeRepository $tradeRepo
    ) { 
        return response()->json(
            [
                'success' => false,
                'message' => 'Not implemented yet'
            ]
        );
    }
}
