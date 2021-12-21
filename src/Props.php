<?php

namespace App;

class Props {

    public Int $health;
    private bool $state;
    private Int $position;

    public function __construct($health){

        $this->health = $health;
        $this->state = true;
        $this->position = 0;
    }

    public function GetHealth() {
        return $this->health;
    }

    public function setHealth($health) {
        $this->health = $health;
        return $this;
    }

    public function GetState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
        return $this;
    }

    public function setLevel($level) {
        $this->level = $level;
        return $this;
    }

    public function GetPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;
        return $this;
    }

}