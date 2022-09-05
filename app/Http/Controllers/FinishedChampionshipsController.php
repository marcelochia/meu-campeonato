<?php

namespace App\Http\Controllers;

use App\Http\Resources\FinishedChampionshipsResource;
use App\Models\FinishedChampionship;

class FinishedChampionshipsController extends Controller
{
    public function all()
    {
        $finishedChampionships = FinishedChampionship::all();

        foreach ($finishedChampionships as $finishedChampionship) {
            $championships[] = new FinishedChampionshipsResource($finishedChampionship);
        }
        
        return response()->json($championships);
    }
}
