<?php

namespace App\Services;

class ChampionshipService
{
    private array $teams;
    private array $winnersRoundOf8;
    private array $winnersSemifinals;
    private array $playersOfThirdPlacePlayoff;
    private array $thirdPlace;
    private array $secondPlace;
    private array $firstPlace;

    public function __construct(private array $championship)
        {
        $this->teams = [];
        $this->winnersRoundOf8 = [];
        $this->winnersSemifinals = [];
        $this->playersOfThirdPlacePlayoff = [];
        $this->thirdPlace = [];
        $this->secondPlace = [];
        $this->firstPlace = [];
    }
    
    public function startChampionship()
    {
        $i = 0;
        foreach ($this->championship as $team) {
            $i++;
            $this->teams[] = [
                'id' => $team['id'],
                'name' => $team['name'],
                'subscription_order' => $i,
                'points' => 0,
                'winner' => false
            ];
        }

        shuffle($this->teams);
        
        $this->roundOf8();

        $this->semifinals();

        $this->thirdPlacePlayoff();

        $this->final();

        return [
            'firstPlace' => 
                [
                    'id' => $this->firstPlace[0]['id'],
                    'name' => $this->firstPlace[0]['name']
                ]
            ,
            'secondPlace' => 
                [
                    'id' => $this->secondPlace[0]['id'],
                    'name' => $this->secondPlace[0]['name']
                ]
            ,
            'thirdPlace' => 
                [
                    'id' => $this->thirdPlace[0]['id'],
                    'name' => $this->thirdPlace[0]['name']
                ]
            ,
        ];
    }

    private function roundOf8()
    {
        $groups[] = [$this->teams[0], $this->teams[1]];
        $groups[] = [$this->teams[2], $this->teams[3]];
        $groups[] = [$this->teams[4], $this->teams[5]];
        $groups[] = [$this->teams[6], $this->teams[7]];
        
        $matchesResults = $this->match($groups);
        
        $results = $this->setResults($matchesResults);

        for ($i=0; $i < count($results); $i++) { 
            if ($results[$i]['winner']) {
                $this->winnersRoundOf8[] = $results[$i];
            }
        }
    }

    private function semifinals()
    {
        $matchesResults = [];
        
        $groups[] = [$this->winnersRoundOf8[0], $this->winnersRoundOf8[1]];
        $groups[] = [$this->winnersRoundOf8[2], $this->winnersRoundOf8[3]];

        $matchesResults = $this->match($groups);
        
        $results = $this->setResults($matchesResults);

        for ($i=0; $i < count($results); $i++) { 
            if ($results[$i]['winner']) {
                $this->winnersSemifinals[] = $results[$i];
            } else {
                $this->playersOfThirdPlacePlayoff[] = $results[$i];
            }
        }
    }

    private function thirdPlacePlayoff()
    {
        $matchResult = [];

        $matchResult = $this->match([$this->playersOfThirdPlacePlayoff], false);
        
        $results = $this->setResults($matchResult);

        for ($i=0; $i < count($results); $i++) { 
            if ($results[$i]['winner']) {
                $this->thirdPlace[] = $results[$i];
            }
        }
    }

    private function final()
    {
        $matchResult = [];
        
        $matchResult = $this->match([$this->winnersSemifinals]);
        
        $results = $this->setResults($matchResult);

        for ($i=0; $i < count($results); $i++) { 
            if ($results[$i]['winner']) {
                $this->firstPlace[] = $results[$i];
            } else {
                $this->secondPlace[] = $results[$i];
            }
        }
    }

    private function match(array $groups)
    {
        $matchesResults = [];

        for ($i=0; $i < count($groups); $i++) { 
            $matchService = new MatchService($groups[$i]);
            $matchesResults[] = $matchService->play();
        }

        return $matchesResults;
    }

    private function setResults(array $results)
    {
        $teams = [];
        foreach ($results as $result) {
            for ($i=0; $i < count($result); $i++) {
                $teams[] = $result[$i];
            }
        }

        for ($i=0; $i < count($teams); $i++) {

            for ($j=0; $j < count($teams); $j++) {

                
                if ($this->teams[$j]['id'] === $teams[$i]['id']) {
                    $this->teams[$j]['points'] += $teams[$i]['points'];
                    $this->teams[$j]['winner'] = $teams[$i]['winner'];
                }
            }
        }

        return $teams;
    }
}
