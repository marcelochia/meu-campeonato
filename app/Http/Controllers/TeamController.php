<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        return response()->json(Team::all());
    }

    public function store(TeamRequest $request)
    {
        $team = Team::create($request->all());
        return response()->json($team, 201);
    }

    public function show(int $id)
    {
        $team = Team::find($id);

        if (is_null($team)) {
            return response()->noContent();
        }

        return response()->json($team);
    }

    public function update(int $id, TeamRequest $request)
    {
        $team = Team::find($id);

        if (is_null($team)) {
            return response()->noContent();
        }

        $team->fill($request->all());
        $team->save();

        return response()->json($team);
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return response()->json();
    }
}
