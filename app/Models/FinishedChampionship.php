<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishedChampionship extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'finished_championships';
    protected $fillable = [
        'championship_id',
        'first_place_team',
        'second_place_team',
        'third_place_team'
    ];

    public function championship()
    {
        return $this->belongsTo(Championship::class, 'championship_id', 'id');
    }

    public function firstPlace()
    {
        return $this->belongsTo(Team::class, 'first_place_team', 'id');
    }

    public function secondPlace()
    {
        return $this->belongsTo(Team::class, 'second_place_team', 'id');
    }

    public function thirdPlace()
    {
        return $this->belongsTo(Team::class, 'third_place_team', 'id');
    }
}
