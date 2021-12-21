<?php

namespace App;

class Character {

    private $health;
    private $level;
    private $state;
    private $damage;
    private $healing;
    private $range;
    private $position;

    public $combatStyle;

    public function __construct($combatStyle){

        $this->health = 1000;
        $this->level = 1;
        $this->state = true;
        $this->damage = 600;
        $this->healing = 100;
        $this->position = 0;
        $this->combatStyle = $combatStyle;
        $this->faction = array();

        if ($combatStyle == 1) {
            $this->range = 2;
        }
        if ($combatStyle == 2) {
            $this->range = 20;
        }
    }

    public function GetHealth() {
        return $this->health;
    }

    public function setHealth($health) {
        $this->health = $health;
        return $this;
    }

    public function GetLevel() {
        return $this->level;
    }

    public function setLevel($level) {
        $this->level = $level;
        return $this;
    }

    public function GetState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
        return $this;
    }

    public function GetDamage() {
        return $this->damage;
    }

    public function GetHealing() {
        return $this->healing;
    }

    public function GetPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;
        return $this;
    }

    public function GetRange() {
        return $this->range;
    }

    public function GetFaction() {
        return $this->faction;
    }

    public function DealDamage($objective) {
        if (get_class($objective)==="App\Props") {
            $objective->SetHealth($objective->GetHealth() - $this->damage);
            if($objective->GetHealth() < 1) {
                $objective->SetState(false);
                $objective->SetHealth(0);
            };
            return;
        }
        if(($this !== $objective && (count(array_intersect($this->faction, $objective->GetFaction())) == 0)) && ($this->range > ($objective->GetPosition() - $this->position))) {
            if(($objective->GetLevel() - $this->level) >= 5) {
                $objective->SetHealth($objective->getHealth() - $this->damage / 2);
                return;
            }
            if(($this->level - $objective->GetLevel()) >= 5) {
                $objective->SetHealth($objective->GetHealth() - ($this->damage * 1.5));
                return;
            }
           $objective->SetHealth($objective->GetHealth() - $this->damage);
        }
        if($objective->GetHealth() < 1) {
            $objective->SetState(false);
            $objective->SetHealth(0);
        };
    } 

    public function Healing($objective) {
        if (get_class($objective)==="App\Props") {
            return;}
        if(($this == $objective or count(array_intersect($this->faction, $objective->GetFaction())) > 0) && $objective->GetHealth() > 0) {
            $objective->setHealth($objective->GetHealth() + $this->healing);
        }
        if($objective->GetHealth() > 1000) {
            $objective->setHealth (1000);
        }
    }

    public function JoinFaction ($faction) {
        if ($faction == 1) {
            array_push($this->faction, 'Demacia');
        }
        if ($faction == 2) {
            array_push($this->faction, 'Noxus');
        }
        if ($faction == 3) {
            array_push($this->faction, 'Freljord');
        }
        if ($faction == 4) {
            array_push($this->faction, 'Piltover');
        }
    }

    public function LeaveFaction ($delete) {
        if ($delete == 1) {
            $key = array_search('Demacia', $this->faction);
            unset($this->faction[$key]);
        }
        if ($delete == 2) {
            $key = array_search('Noxus', $this->faction);
            unset($this->faction[$key]);
        }
        if ($delete == 3) {
            $key = array_search('Freljord', $this->faction);
            unset($this->faction[$key]);
        }
        if ($delete == 4) {
            $key = array_search('Piltover', $this->faction);
            unset($this->faction[$key]);
        }
    }  
}
?>