<?php
namespace StatStick;

use StatStick\Artifact;
use StatStick\BaseStatStick;

class ArtifactCollection Extends BaseStatStick
{
	private $flower = array();

	private $feather = array();

	private $hourglass = array();

	private $goblet = array();

	private $circlet = array();

	public $setEffects = array();

	public function addArtifact(Artifact $artifact, $type)
	{
		if (!in_array($type, ['flower', 'feather', 'hourglass', 'goblet', 'circlet']))
		{
			throw new Exception("Attempted add an artifact of incompatible type");
		}

		$this->{$type}[] = $artifact;
	}

	public function addSetEffect($set, $requirement, BaseStatStick $bonus)
	{
		$this->setEffects[$set][$requirement] = $bonus;
	}

	public function getAllArtifactCombinationStatValues()
	{
		$artifactCombinations = $this->getAllArtifactCombinations();
	}

	public function getAllArtifactCombinations()
	{
		$combinations = [[]];

		// Consolidate all our artifacts
		$allArtifacts = [
			$this->flower,
			$this->feather,
			$this->hourglass,
			$this->goblet,
			$this->circlet
		];

		// Go through all our artifact types
		for ($i = 0; $i < 5; $i++) {
			$tmp = [];

			// Go through all our existing combinations, so we can add artifacts of current type to them
			foreach ($combinations as $combination)
			{
				// Loop through all artifacts of type
				foreach ($allArtifacts[$i] as $artifact)
				{
					// Merge combination with artifact
					$tmp[] = array_merge($combination, [$artifact]);
				}

			}

			// Overwrite our combinations with the newest iteration of combinations
			$combinations = $tmp;
		}

		return $combinations;
	}
}
