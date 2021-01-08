<?php
namespace StatStick;

use StatStick\Artifact;
use StatStick\BaseStatStick;

class ArtifactCollection Extends BaseStatStick
{
	private $artifacts = array();

	private $damageMultiplier = 0;

	public function addArtifact(Artifact $artifact)
	{
		$this->artifacts[] = $artifact;

		$this->addArtifactStatValues($artifact);
	}

	public function addArtifactStatValues(Artifact $artifact)
	{
		$this->addFlatAttack($artifact->flatAttack)
			->addAttackPercent($artifact->attackPercent)
			->addCritRate($artifact->critRate)
			->addCritDamage($artifact->critDamage)
			->addDamageBonus($artifact->damageBonus);
	}
}
