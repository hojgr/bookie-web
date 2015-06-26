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
use Illuminate\Redis\Database;

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
     * @param Database            $redis      Redis connection
     *
     * @return void
     */
    public function handle(UserTradeRepository $repository, Database $redis)
    {
        $currentId = $redis->incr('trade:counter');

        $data = [
            "type" => "request", // request | return
            "steamid" => auth()->getUser()->steam_id,
            "token" => auth()->getUser()->user_trade_link->token,
            "message" => "No message yet",
            "items" => array_values(
                array_map(
                    function ($a) {
                        return $a['id'];
                    },
                    $this->items
                )
            ),
        ];

        $json_data = json_encode($data);

        $base64_data = base64_encode($json_data);

        $redis->set("trade:offer:$currentId", $base64_data);

        $repository->createTradeDeposit($this->user, $currentId, $this->items);

        $redis->rpush('trade:queue', $currentId);

    }
}
