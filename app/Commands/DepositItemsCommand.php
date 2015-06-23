<?php
/**
 * A command that creates an item deposit request
 *
 * PHP version 5.6
 *
 * @category Class
 * @package  BookieGG\Models
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
namespace BookieGG\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use BookieGG\Models\User;
use BookieGG\Repositories\Eloquent\UserTradeRepository;

/**
 * A command that creates an item deposit request
 *
 * @category Class
 * @package  BookieGG\Models
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
class DepositItemsCommand extends Command implements SelfHandling
{

    /**
     * Items to be deposited to system
     *
     * @var array
     */
    protected $items;

    /**
     * User that is depositing items
     *
     * @var User $user
     */
    protected $user;

    /**
     * Constructor
     *
     * @param User  $user  User that is depositing items
     * @param array $items Items to be deposited
     */
    public function __construct(User $user, array $items)
    {
        $this->items = $items;
        $this->user = $user;
    }

    /**
     * Command execution
     *
     * @param UserTradeRepository $repository Repository
     *
     * @return void
     */
    public function handle(UserTradeRepository $repository)
    {
        $repository->createTradeDeposit($this->user, $this->items);
        // insert it to redis
    }
}
