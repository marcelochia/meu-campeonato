<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChampionshipRequest;
use App\Http\Resources\ChampionshipResource;
use App\Models\Championship;
use App\Models\ChampionshipTeams;
use App\Models\Team;
use Illuminate\Http\Request;

class ChampionshipController extends Controller
{
    public function index()
    {
        $championship = Championship::paginate(5);
        
        return response()->json($championship);
    }

    public function store(ChampionshipRequest $request)
    {
        if (count($request->teams) !== 8) {
            return response()->json(['error' => 'O campeonato deve ter exatamente 8 times registrados'], 400);
        }

        $championship = Championship::create([
            'name' => $request->name
        ]);

        foreach ($request->teams as $team) {
            ChampionshipTeams::create([
                'championship_id' => $championship->id,
                'team_id' => $team
            ]);
        }

        $championshipResource = new ChampionshipResource($championship);

        return response()->json($championshipResource);
    }

    public function show($id)
    {
        $championship = Championship::find($id);

        if (is_null($championship)) {
            return response()->noContent();
        }

        $championshipResource = new ChampionshipResource($championship);

        return response()->json($championshipResource);    }

    public function update(ChampionshipRequest $request, $id)
    {
        $championship = Championship::find($id);

        if (is_null($championship)) {
            return response()->noContent();
        }

        $championship->fill($request->all());
        $championship->save();

        return response()->json($championship);
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return response()->json();
    }
}
