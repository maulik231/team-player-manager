<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Support\Facades\Validator;


class TeamPlayerController extends Controller
{
    public function getTeamAndPlayer()
    {
        $teams = Team::with([
            'players' => function ($query) {
                $query->orderBy('team_player.sort_order');
            }
        ])->get();

        $players = Player::whereDoesntHave('teams')->get();

        return response()->json(['teams' => $teams, 'players' => $players]);
    }

    public function saveTeams(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'teams' => 'required|array',
            'teams.*.id' => 'required|exists:teams,id',
            'teams.*.players' => 'sometimes|array',
            'teams.*.players.*.id' => 'sometimes|exists:players,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        foreach ($request->teams as $teamData) {
            $team = Team::find($teamData['id']);
            $players = collect($teamData['players'])->mapWithKeys(function ($player, $index) {
                return [$player['id'] => ['sort_order' => $index]];
            });

            $team->players()->sync($players);
        }

        return response()->json(['message' => 'Teams updated successfully']);
    }
}
