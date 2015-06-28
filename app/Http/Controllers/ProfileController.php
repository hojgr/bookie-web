<?php


namespace BookieGG\Http\Controllers;

class ProfileController extends Controller {
    public function show() {
        $tradeUrl = "http://steamcommunity.com/tradeoffer/new/?partner=39424490&token=86voRSP_";
        
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

        // Data for the user to display
        // Route should support both /profile/{id} and /profile/me
        $user = (object) [
            "avatar_path" => "f5/f5779964fa870cad057ff80e21e5a4d450f31925_medium.jpg",
            "display_name" => "Birjoylaxew",
            "profile_name" => "birjolaxew"
        ];

        return view("profile/profile")
            ->with('tradeUrl', $tradeUrl)
            ->with('matchHistory', $matchHistory)
            ->with('userData', $user);
    }

    /**
     * Verifies Trade URL
     *
     * @return json
     */
    public function verifyTradeURL()
    {
        return response()->json(
            [
                'success' => true,
                'valid' => true
            ]
        );
    }
}
