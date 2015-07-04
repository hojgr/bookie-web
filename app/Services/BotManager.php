<?php
/**
 * Manages bots
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

use BookieGG\Models\Bot;

class BotManager
{
    public function getOrCreate($botSteamId, $botDisplayName)
    {
        $bot = Bot::firstOrCreate(['steam_id' => $botSteamId]);

        if ($bot->display_name !== $botDisplayName) {
            $bot->display_name = $botDisplayName;
            $bot->save();
        }

        return $bot;
    }
}
