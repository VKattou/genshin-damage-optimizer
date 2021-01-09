<?php
namespace StatStick;

use StatStick\BaseStatStick;

class Character extends BaseStatStick
{
	public $name;
	public $baseAttack;

	public function __construct($name, $baseAttack)
	{
		$this->name       = $name;
		$this->baseAttack = $baseAttack;

		// Add character base crit rate/damage
		$this->addCritRate(5);
		$this->addCritDamage(50);
	}
}
