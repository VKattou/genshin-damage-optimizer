<?php
namespace StatStick;

use StatStick\BaseStatStick;

class Weapon extends BaseStatStick
{
	private $baseAttack;

	private $damageMultiplier;

	public function __construct($baseAttack)
	{
		$this->baseAttack = $baseAttack;
	}

	public function getBaseAttack()
	{
		return $this->baseAttack;
	}
}

