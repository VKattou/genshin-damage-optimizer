<?php
namespace StatStick;

use StatStick\BaseStatStick;

class Character extends BaseStatStick
{
	private $name;

	private $baseAttack;

	public function __construct($name, $baseAttack)
	{
		$this->name       = $name;
		$this->baseAttack = $baseAttack;

		//add character base crit rate/damage
		$this->addCritRate(5);
		$this->addCritDamage(50);
	}

	public function getName()
	{
		return $this->name;
	}

	public function getBaseAttack()
	{
		return $this->baseAttack;
	}
}
