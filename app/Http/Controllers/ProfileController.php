<?php
/**
 * A class that handles all profile-related actions
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

use Illuminate\Http\Request;

/**
 * Profile Controller
 *
 * PHP version 5.6
 *
 * @category Class
 * @package  BookieGG\Http\Controllers
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
class ProfileController extends Controller
{
    /**
     * Shows profile page
     *
     * @return Response
     */
    public function show()
    {
        $matchHistory = [
            (object) [
                "team_1" => "Titan",
                "team_2" => "CW",
                "winner" => 2,
                "userBet" => 1,
                "timeStr" => "2015-02-14 12:34",
                "matchId" => 1
            ],
            (object) [
                "team_1" => "C9",
                "team_2" => "F3",
                "winner" => 0,
                "userBet" => 1,
                "timeStr" => "2015-02-13 12:34",
                "matchId" => 2
            ],
            (object) [
                "team_1" => "Titan",
                "team_2" => "C9",
                "winner" => 1,
                "userBet" => 1,
                "timeStr" => "2015-02-12 12:34",
                "matchId" => 3
            ],
            (object) [
                "team_1" => "C9",
                "team_2" => "Titan",
                "winner" => 2,
                "userBet" => 2,
                "timeStr" => "2015-02-11 12:34",
                "matchId" => 1
            ]
        ];

        return view("profile/profile")
            ->with('matchHistory', $matchHistory);
    }

    /**
     * Verifies Trade URL
     *
     * @param Request $request Request
     *
     * @return json
     */
    public function verifyTradeURL(Request $request)
    {
        $regex = '~(https?://)?steamcommunity.com'
                . '/tradeoffer/new/cxv cxpartner=[0-9]+&token=[0-9a-zA-Z]+~';

        return response()->json(
            [
                'success' => true,
                'valid' => preg_match(
                    $regex,
                    $request->input('tradeURL')
                )
            ]
        );
    }
}
