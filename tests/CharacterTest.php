<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Character;
use App\Props;


class CharacterTest extends TestCase {

	public function test_Create_Character()
	{
		//Given
		$character = new Character(1);
		//When
		$health = $character->GetHealth();
		$level = $character->GetLevel();
		$state = $character->GetState();
		//Then
		$this->assertEquals(1000, $health);
		$this->assertEquals(1, $level);
		$this->assertEquals(true, $state);
	}

	public function test_DealDamage_Character() 
	{
		//Given
		$hero = new Character(1);
		$villan = new Character(1);
		//When
		$hero->DealDamage($villan);
		$health = $villan->GetHealth();
		//Then
		$this->assertEquals(400, $health);
	}
	
	public function test_dead_Character () {

		//Given
		$hero = new Character(1);
		$villan = new Character(1);
		//When
		$hero->DealDamage($villan);
		$health = $villan->GetHealth();
		$state = $villan->GetState();
		$hero->DealDamage($villan);
		$health = $villan->GetHealth();
		$state = $villan->GetState();
		//Then
		$this->assertEquals(0, $health);
		$this->assertEquals(false, $state);
	}

	public function test_heal_Character () {
		
		//Given
		$hero = new Character(1);
		$villan = new Character(1);
		$hero->DealDamage($villan);
		//When
		$villan->Healing($villan);
		$health = $villan->GetHealth();
		//Then
		$this->assertEquals(500, $health);
	}

	public function test_heal_Dead_Character () {
		
		//Given
		$hero = new Character(1);
		$villan = new Character(1);
		$hero->DealDamage($villan);
		$hero->DealDamage($villan);
		//When
		$villan->Healing($villan);
		$health = $villan->GetHealth();
		//Then
		$this->assertEquals(0, $health);
	}

	public function test_heal_full_Character () {
		
		//Given
		$hero = new Character(1);
		$villan = new Character(1);
		//When
		$villan->Healing($villan);
		$health = $villan->GetHealth();
		//Then
		$this->assertEquals(1000, $health);
	}

	public function test_Damage_Himself() 
	{
		//Given
		$hero = new Character(1);
		//When
		$hero->DealDamage($hero);
		$health = $hero->GetHealth();
		//Then
		$this->assertEquals(1000, $health);
	}

	public function test_heal_himself () {
		
		//Given
		$hero = new Character(1);
		$villan = new Character(1);
		$hero->DealDamage($villan);
		//When
		$hero->Healing($villan);
		$health = $villan->GetHealth();
		//Then
		$this->assertEquals(400, $health);
	}

	public function test_defense_highlevel () {
		
		//Given
		$hero = new Character(1);
		$villan = new Character(1);
		$hero->setLevel(6);
		//When
		$villan->DealDamage($hero);
		$health = $hero->GetHealth();
		//Then
		$this->assertEquals(700, $health);
	}

	public function test_attack_highlevel () {
		
		//Given
		$hero = new Character(1);
		$villan = new Character(1);
		$hero->setLevel(6);
		//When
		$hero->DealDamage($villan);
		$health = $villan->GetHealth();
		//Then
		$this->assertEquals(100, $health);
	}

	public function test_range_melee () {
		
		//Given
		$hero = new Character(1);
		//When
		$range = $hero->GetRange();
		//Then
		$this->assertEquals(2, $range);
	}

	public function test_range_ranged () {
		
		//Given
		$hero = new Character(2);
		//When
		$range = $hero->GetRange();
		//Then
		$this->assertEquals(20, $range);
	}

	public function test_attack_out_of_range () {
		
		//Given
		$hero = new Character(1);
		$villan = new Character(1);
		$hero->setPosition(3);
		//When
		$villan->DealDamage($hero);
		$health = $hero->GetHealth();
		//Then
		$this->assertEquals(1000, $health);
	}

	public function test_attack_in_range () {
		
		//Given
		$hero = new Character(2);
		$hero->setLevel(6);
		$villan = new Character(1);
		$villan->setPosition(19);
		//When
		$hero->DealDamage($villan);
		$health = $villan->GetHealth();
		//Then
		$this->assertEquals(100, $health);
	}

	public function test_faction () {
		
		//Given
		$hero = new Character(1);
		//When
		$faction = $hero->GetFaction();
		//Then
		$this->assertEquals(array(), $faction);
	}

	public function test_join_one_faction () {
		
		//Given
		$hero = new Character(1);
		//When
		$hero->JoinFaction(1);
		$faction = $hero->GetFaction();
		//Then
		$this->assertEquals( array ('Demacia'), $faction);
	}

	public function test_more_faction () {
		
		//Given
		$hero = new Character(1);
		//When
		$hero->JoinFaction(1);
		$hero->JoinFaction(4);
		$faction = $hero->GetFaction();
		//Then
		$this->assertEquals( array('Demacia', 'Piltover'), $faction);
		
	}

	public function test_leave_faction () {
		
		//Given
		$hero = new Character(1);
		//When
		$hero->JoinFaction(1);
		$hero->JoinFaction(2);
		$hero->JoinFaction(3);
		$hero->LeaveFaction(2);
		$faction = $hero->GetFaction();
		//Then
		$this->assertEqualsCanonicalizing( array('Demacia','Freljord'), $faction);
		
	}

	public function test_attack_allie () {
		
		//Given
		$hero = new Character(1);
		$villan = new Character(1);
		$hero->JoinFaction(1);
		$hero->JoinFaction(2);
		$hero->JoinFaction(3);
		$villan->JoinFaction(4);
		$villan->JoinFaction(1);
		//When
		$hero->DealDamage($villan);
		$health = $villan->GetHealth();
		//Then
		$this->assertEquals(1000, $health);
	}

	public function test_attack_enemie () {
		
		//Given
		$hero = new Character(1);
		$villan = new Character(1);
		$hero->JoinFaction(1);
		$hero->JoinFaction(2);
		$hero->JoinFaction(3);
		$villan->JoinFaction(4);
		//When
		$hero->DealDamage($villan);
		$health = $villan->GetHealth();
		//Then
		$this->assertEquals(400, $health);
	}

	public function test_attack_neutral () {
		
		//Given
		$hero = new Character(1);
		$villan = new Character(1);
		$hero->JoinFaction(1);
		//When
		$hero->DealDamage($villan);
		$health = $villan->GetHealth();
		//Then
		$this->assertEquals(400, $health);
	}

	public function test_heal_enemie () {
		
		//Given
		$hero = new Character(1);
		$villan = new Character(1);
		$hero->JoinFaction(3);
		$villan->JoinFaction(4);
		//When
		$hero->DealDamage($villan);
		$hero->Healing($villan);
		$health = $villan->GetHealth();
		//Then
		$this->assertEquals(400, $health);
	}

	public function test_heal_allie () {
		
		//Given
		$hero = new Character(1);
		$hero2 = new Character(1);
		$villan = new Character(1);
		$hero->JoinFaction(3);
		$hero2->JoinFaction(3);
		$villan->JoinFaction(4);
		//When
		$villan->DealDamage($hero);
		$villan->DealDamage($hero2);
		$hero->Healing($hero2);
		$hero2->Healing($hero);
		$health = $hero->GetHealth();
		$health2 = $hero2->GetHealth();
		//Then
		$this->assertEquals(500, $health2);
		$this->assertEquals(500, $health);
	}

	public function test_attack_prop () {
		
		//Given
		$villan = new Character(1);
		$box = new Props(300);
		$box->setPosition(1);
		//When
		$villan->DealDamage($box);
		$health = $box->GetHealth();
		$state = $box->GetState();
		//Then
		$this->assertEquals(0, $health);
		$this->assertEquals(false, $state);
	}
}
?>