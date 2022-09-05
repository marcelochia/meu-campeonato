<?php

namespace App\Services;

use Symfony\Component\Process\Process;

class MatchService
{
    public function __construct(private array $group)
    { }

    public function play()
    {
        $matchResult = $this->executeMatchResult();

        for ($i=0; $i < count($this->group); $i++) {
            $this->group[$i]['points'] = 0;
            $this->group[$i]['goals'] = $matchResult[$i];
        }

        $this->calculatePoints();
        
        for ($i=0; $i < count($this->group); $i++) { 
            $this->group[$i]['winner'] = $this->group[$i]['points'] > 0 ? true : false;
        }
        
        if ($this->group[0]['points'] === $this->group[1]['points']) {
            $this->tieBreaker();
        }
        
        return $this->group;
    }

    private function calculatePoints()
    {
        $this->group[0]['points'] += $this->group[0]['goals'] - $this->group[1]['goals'];
        $this->group[1]['points'] += $this->group[1]['goals'] - $this->group[0]['goals'];
    }

    private function tieBreaker()
    {
        if ($this->group[0]['points'] > $this->group[1]['points']) {
            $this->group[0]['winner'] = true;
            $this->group[1]['winner'] = false;
            return;
        }
        
        if ($this->group[1]['points'] > $this->group[0]['points']) {
            $this->group[1]['winner'] = true;
            $this->group[0]['winner'] = false;
            return;
        }

        if ($this->group[0]['subscription_order'] < $this->group[1]['subscription_order']) {
            $this->group[0]['winner'] = true;
            $this->group[1]['winner'] = false;
            return;
        }
        
        if ($this->group[1]['subscription_order'] < $this->group[0]['subscription_order']) {
            $this->group[1]['winner'] = true;
            $this->group[0]['winner'] = false;
            return;
        }
    }

    private function executeMatchResult()
    {
        $process = new Process(['python3', base_path() .'/teste.py']);
        $process->run();

        $result = rtrim($process->getOutput(), "\n");

        $result = explode(\PHP_EOL, $result);
        
        return $result;
    }
}
