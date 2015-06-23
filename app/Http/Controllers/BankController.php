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
use \Illuminate\Http\Request;
use BookieGG\Commands\DepositItemsCommand;

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
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(
        InventoryLoaderInterface $inventoryLoader,
        BankLoaderInterface $bankLoader,
        Guard $guard
    ) {
        $inventory = $inventoryLoader->loadSteamInventory(
            $guard->getUser()->steam_id
        );

        $bank = $bankLoader->load($guard->getUser());

        return view("bank/bank")
            ->with('userInventory', $inventory)
            ->with('userBank', $bank);
    }

    /**
     * Initiates an operation for moving items from
     * user's steam inventory to our bot's inventory
     *
     * @param Request $request HTTP Request
     *
     * @see http://docs.bookiegg.apiary.io/#reference/betting-api/make-bet
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deposit(Request $request)
    {
        $items = $request->input('items');

        $this->dispatch(
            new DepositItemsCommand(
                \Auth::getUser(),
                $items
            )
        );
    }
}
