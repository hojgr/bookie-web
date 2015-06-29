<?php
/**
 * A command that creates an item withdraw request
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
use Illuminate\Redis\Database;

/**
 * A command that creates an item withdraw request
 *
 * @category Class
 * @package  BookieGG\Models
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
class WithdrawItemsCommand extends Command implements SelfHandling
{

    /**
     * Items to be withdrawn from system
     *
     * @var array
     */
    protected $items;

    /**
     * User that is withdrawing items
     *
     * @var User $user
     */
    protected $user;

    /**
     * Constructor
     *
     * @param User  $user  User that is withdrawing items
     * @param array $items Items to be withdrawn
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
     * @param Database            $redis      Redis connection
     *
     * @return void
     */
    public function handle(UserTradeRepository $repository, Database $redis)
    {
        $currentId = $redis->incr('trade:counter');

        $itemsStored = $repository->createTradeWithdraw(
            $this->user,
            $currentId,
            $this->items
        );


        $data = [
            "type" => "return", // request | return
            "steamid" => auth()->getUser()->steam_id,
            "token" => auth()->getUser()->user_trade_link->token,
            "message" => "No message yet",
            "items" => array_values(
                array_map(
                    function ($a) {
                        return $a->user_bank->csgo_item->market_name;
                    },
                    $itemsStored
                )
            ),
        ];

        $json_data = json_encode($data);

        $base64_data = base64_encode($json_data);

        $redis->set("trade:offer:$currentId", $base64_data);

        $redis->rpush('trade:queue', $currentId);

    }
}
