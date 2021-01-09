<?php
namespace StatStick;

class BaseStatStick
{
	protected $flatAttack       = 0;
	protected $attackPercent    = 0;
	protected $critRate         = 0;
	protected $critDamage       = 0;
	protected $damageBonus      = 0;
	protected $energyRecharge   = 0;
	protected $elementalMastery = 0;
	
	public function addFlatAttack($value)
	{
		$this->flatAttack += $value;

		return $this;
	}
	
	public function addAttackPercent($value)
	{
		$this->attackPercent += $value;

		return $this;
	}
	
	public function addCritRate($value)
	{
		$this->critRate += $value;

		return $this;
	}
	
	public function addCritDamage($value)
	{
		$this->critDamage += $value;

		return $this;
	}

	public function addDamageBonus($value)
	{
		$this->damageBonus += $value;

		return $this;
	}

	public function addEnergyRecharge($value)
	{
		$this->energyRecharge += $value;

		return $this;
	}

	public function addElementalMastery($value)
	{
		$this->elementalMastery += $value;

		return $this;
	}
	
	public function __get($property)
	{
		if (property_exists($this, $property))
		{
			return $this->$property;
		}
		else
		{
			throw new Exception("Attempted to get a non-existing stat");
		}
	}

	public function combineStatSticks(BaseStatStick $statStick)
	{
		$this->addFlatAttack($statStick->flatAttack)
			->addAttackPercent($statStick->attackPercent)
			->addCritRate($statStick->critRate)
			->addCritDamage($statStick->critDamage)
			->addDamageBonus($statStick->damageBonus)
			->addEnergyRecharge($statStick->energyRecharge)
			->addElementalMastery($statStick->elementalMastery);
	}
}
