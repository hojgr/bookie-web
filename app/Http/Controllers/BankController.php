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
use BookieGG\Commands\WithdrawItemsCommand;
use BookieGG\Services\TradeManager;

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
        // $pendingDeposit and $pendingWithdraw are arrays with IDs
        list($pendingDeposit, $pendingWithdraw) = $tradeRepo->getPendingTrade($guard->getUser());

        list($inventory, $inventoryPending) = $inventoryLoader->getSteamInventory(
            $guard->getUser()->steam_id,
            $pendingDeposit
        );

        list($bank, $bankPending) = $bankLoader->load($guard->getUser(), $pendingWithdraw);

        return view("bank/bank")
            ->with('userInventory', $inventory)
            ->with('userInventoryPending', $inventoryPending)
            ->with('userBank', $bank)
            ->with('userBankPending', $bankPending);

    }

    /**
     * Checks for pending trade
     *
     * If returns a type of Response, trade is pending and should be returned.
     * Otherwise none is pending
     *
     * @param UserTradeRepository $tradeRepo Trade repo
     *
     * @return Response|bool
     */
    public function checkPendingTrades(UserTradeRepository $tradeRepo)
    {
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

        return false;
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
        if (count($request->input('items')) == 0) {
            return response()->json(
                [
                    'success' => 'false',
                    'messageType' => 'error',
                    'message' => 'You must select items to deposit!'
                ]
            );
        }

        if (count($request->input('items')) > 10) {
            return response()->json(
                [
                    'success' => 'false',
                    'messageType' => 'error',
                    'message' => 'You can\'t deposite more than 10 items at the same time!'
                ]
            );
        }

        $hasTradePending = $this->checkpendingTrades($tradeRepo);

        if ($hasTradePending) {
            return $hasTradePending;
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
                'popup' => true,
                'success' => true
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
        if (count($request->input('items')) == 0) {
            return response()->json(
                [
                    'success' => 'false',
                    'messageType' => 'error',
                    'message' => 'You must select items to deposit!'
                ]
            );
        }

        if (count($request->input('items')) > 10) {
            return response()->json(
                [
                    'success' => 'false',
                    'messageType' => 'error',
                    'message' => 'You can\'t deposite more than 10 items at the same time!'
                ]
            );
        }

        $hasTradePending = $this->checkpendingTrades($tradeRepo);

        if ($hasTradePending) {
            return $hasTradePending;
        }

        $this->dispatch(
            new WithdrawItemsCommand(
                auth()->getUser(),
                $request->input('items')
            )
        );

        return response()->json(
            [
                'success' => true,
                'popup' => true,
            ]
        );
    }
}
