<?php
namespace Calculator;

use StatStick\ArtifactCollection;
use StatStick\Character;
use StatStick\Weapon;

class Calculator
{
	public function __construct(Character $character, Weapon $weapon, ArtifactCollection $artifacts)
	{
		$this->character = $character;
		$this->weapon    = $weapon;
		$this->artifacts = $artifacts;
	}

	public function calculateDamage()
	{
		// Get our total attack stat (combined calculation of flat attack/attack%)
		$totalAttack = $this->calculateTotalAttack();

		// Total value of damage bonus stats (damage%, elemental damage etc.)
		$totalDamageBonus = $this->character->damageBonus + $this->weapon->damageBonus + $this->artifacts->damageBonus;

		// Total value of crit stats
		$critRateStat   = $this->character->critRate + $this->weapon->critRate + $this->artifacts->critRate;
		$critDamageStat = $this->character->critDamage + $this->weapon->critDamage + $this->artifacts->critDamage;

		// Ew, Math!
		$damage        = $totalAttack * (1 + ($totalDamageBonus / 100));
		$critDamage    = $damage * (1 + $critDamageStat / 100);
		$averageDamage = ($damage * (1 - ($critRateStat / 100))) + ($critDamage * ($critRateStat / 100));

		// Dump our data. Should probably make a better output than just var_dump, huh?
		var_dump('Crit rate', $critRateStat);
		var_dump('Crit damage', $critDamageStat);
		var_dump($damage);
		var_dump($critDamage);
		var_dump($averageDamage);
	}

	public function calculateTotalAttack()
	{
		$characterBaseAttack = $this->character->getBaseAttack();
		$weaponBaseAttack    = $this->weapon->getBaseAttack();

		$totalAttackPercent = $this->character->attackPercent + $this->weapon->attackPercent + $this->artifacts->attackPercent;
		$totalFlatAttack    = $this->character->flatAttack + $this->weapon->flatAttack + $this->artifacts->flatAttack;

		return (($characterBaseAttack + $weaponBaseAttack) * (1 + ($totalAttackPercent / 100))) + $totalFlatAttack;
	}
}
