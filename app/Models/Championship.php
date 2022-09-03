<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Championship extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name'];

    public function teams()
    {
        return $this->hasManyThrough(Team::class, ChampionshipTeams::class, 'championship_id', 'id', 'id', 'team_id');
        // return $this->hasMany(ChampionshipTeams::class, 'championship_id', 'id');
    }
}
