<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChampionshipTeams extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'championship_teams';
    protected $fillable = [
        'championship_id',
        'team_id'
    ];
}
