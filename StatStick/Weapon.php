<?php
namespace StatStick;

use StatStick\BaseStatStick;

class Weapon extends BaseStatStick
{
	public $name;
	public $baseAttack;

	public function __construct($name, $baseAttack)
	{
		$this->name       = $name;
		$this->baseAttack = $baseAttack;
	}
}

