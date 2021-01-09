<?php
namespace StatStick;

use StatStick\BaseStatStick;

class Artifact extends BaseStatStick
{
	public $name;
	public $set;

	public function __construct($name, $set = null)
	{
		$this->name = $name;
		$this->set  = $set;
	}
}
