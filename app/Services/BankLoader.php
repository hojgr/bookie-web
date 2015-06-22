<?php
/**
 * Bank Loader
 *
 * PHP version 5.6
 *
 * @category Class
 * @package  BookieGG\Services
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */

namespace BookieGG\Services;

use BookieGG\Contracts\BankLoaderInterface;
use BookieGG\Models\User;
use BookieGG\Repositories\Eloquent\BankRepository;

/**
 * Bank Loader
 *
 * @category Class
 * @package  BookieGG\Services
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
class BankLoader implements BankLoaderInterface
{
    /**
     * BankLoader constructor
     *
     * @param BankRepository $bankRepository Bank repository
     */
    public function __construct(BankRepository $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }

    /**
     * Loads user's bank
     *
     * @param User $user User of which bank is requested
     *
     * @return object Bank contents
     */
    public function load(User $user)
    {
        $bankItems = $this->bankRepository->getBank($user);

        // generate bank
        $bank = [];
        foreach ($bankItems as $bankItem) {
            $bank[] = (object) [
                "id" => $bankItem->id,
                "weaponName" => $bankItem->csgo_item->market_name,
                "exterior" => $bankItem->csgo_item->csgo_item_exterior->name,
                "quality" =>  $bankItem->csgo_item->csgo_item_quality->name,
                "price" => $bankItem->csgo_item->latestPrice->price,
                "stattrak" => $bankItem->csgo_item->stattrak == 1,
                "image" => $bankItem->csgo_item->getLogoURL()
            ];
        }

        usort(
            $bank,
            function ($a, $b) {
                if ($a->price == $b->price) {
                    return 0;
                }

                if (floatval($b->price) > floatval($a->price)) {
                    return 1;
                }

                return -1;
            }
        );

        return $bank;
    }
}
