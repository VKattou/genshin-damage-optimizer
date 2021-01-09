<?php
namespace Calculator;

use StatStick\BaseStatStick;
use StatStick\ArtifactCollection;
use StatStick\Character;
use StatStick\Weapon;

class Calculator
{
	private $artifactCombinationValues;

	public function __construct(Character $character, $weapon, ArtifactCollection $artifacts)
	{
		$this->character = $character;

		// We want to be able to work with multiple weapons, so we'll make sure we're always working with an array of weapons
		$this->weapons   = !is_array($weapon) ? [$weapon] : $weapon;
		$this->artifacts = $artifacts;
	}

	public function getHighestDamage($topShown = 0)
	{
		$artifactCombinations = $this->artifacts->getAllArtifactCombinations();

		// Get combined values we can more easily work with
		$this->artifactCombinationValues = $this->getArtifactCombinationValues($artifactCombinations);

		// Calculate damage for our combinations
		$damageCalculations = $this->calculateDamageForCombinations();

		// Sort our combinations by damage
		$sortedDamageCalculations = $this->sortDamageCalculations($damageCalculations);

		// Show only top results if specified
		if ($topShown > 0)
		{
			$sortedDamageCalculations = array_slice($sortedDamageCalculations, 0, $topShown);
		}

		// Make pretty (or at least readable) output
		$this->outputTopResults($sortedDamageCalculations);
	}

	private function getArtifactCombinationValues($artifactCombinations)
	{
		$artifactCombinationValues = [];

		// Digest all artifact combinations into a single stat stick we can more easily work with
		foreach ($artifactCombinations AS $combination)
		{
			$combinationName = '';
			$statStick       = new BaseStatStick;
			$setBonuses      = [];

			foreach ($combination AS $artifact)
			{
				$combinationName .= empty($combinationName) ? $artifact->name : ' - ' . $artifact->name;

				$statStick->combineStatSticks($artifact);

				if (!is_null($artifact->set))
				{
					$setBonuses[$artifact->set] = isset($setBonuses[$artifact->set]) ? $setBonuses[$artifact->set] + 1 : 1;
				}
			}

			// Get stats from set bonuses
			foreach ($setBonuses AS $setName => $pieces)
			{
				if (isset($this->artifacts->setEffects[$setName]))
				{
					// Go through all bonuses for this set
					foreach ($this->artifacts->setEffects[$setName] AS $requirement => $bonus)
					{
						if ($pieces >= $requirement)
						{
							$statStick->combineStatSticks($bonus);
						}
					}
				}
			}

			$artifactCombinationValues[] = array(
				'name' => $combinationName,
				'stats' => $statStick,
				'setPieces' => $setBonuses
			);
		}

		return $artifactCombinationValues;
	}

	private function calculateDamageForCombinations()
	{
		$damageCalculations = [];

		// We need to calculate each combination together with a weapon
		foreach ($this->weapons AS $weapon)
		{
			foreach ($this->artifactCombinationValues AS $artifactCombination)
			{
				$data = [];

				$data['name']      = $weapon->name . ' - ' . $artifactCombination['name'];
				$data['setPieces'] = $artifactCombination['setPieces'];

				$damageResults = $this->calculateDamage($weapon, $artifactCombination['stats']);

				$damageCalculations[] = array_merge($data, $damageResults);
			}
		}

		return $damageCalculations;
	}

	private function calculateDamage(Weapon $weapon, BaseStatStick $artifactStats)
	{
		// Get our total attack stat (combined calculation of flat attack/attack%)
		$totalAttack = $this->calculateTotalAttack($weapon, $artifactStats);

		// Total value of damage bonus stats (damage%, elemental damage etc.)
		$totalDamageBonus = $this->character->damageBonus + $weapon->damageBonus + $artifactStats->damageBonus;

		// Total value of crit stats
		$critRateStat   = $this->character->critRate + $weapon->critRate + $artifactStats->critRate;
		$critDamageStat = $this->character->critDamage + $weapon->critDamage + $artifactStats->critDamage;

		// Ew, Math!
		$damage        = $totalAttack * (1 + ($totalDamageBonus / 100));
		$critDamage    = $damage * (1 + $critDamageStat / 100);
		$averageDamage = ($damage * (1 - ($critRateStat / 100))) + ($critDamage * ($critRateStat / 100));

		// Let's grab energy recharge and elemental mastery stats to make proper comparisons
		$energyRecharge   = $this->character->energyRecharge + $weapon->energyRecharge + $artifactStats->energyRecharge;
		$elementalMastery = $this->character->elementalMastery + $weapon->elementalMastery + $artifactStats->elementalMastery;

		return array(
			'damage'           => $damage,
			'critDamage'       => $critDamage,
			'averageDamage'    => $averageDamage,
			'totalAttack'      => $totalAttack,
			'critRateStat'     => $critRateStat,
			'critDamageStat'   => $critDamageStat,
			'energyRecharge'   => $energyRecharge,
			'elementalMastery' => $elementalMastery
		);
	}

	private function calculateTotalAttack(Weapon $weapon, BaseStatStick $artifactStats)
	{
		// Get base attack values
		$characterBaseAttack = $this->character->baseAttack;
		$weaponBaseAttack    = $weapon->baseAttack;

		// Get attack bonus values
		$totalAttackPercent = $this->character->attackPercent + $weapon->attackPercent + $artifactStats->attackPercent;
		$totalFlatAttack    = $this->character->flatAttack + $weapon->flatAttack + $artifactStats->flatAttack;

		// Smash it all together
		return (($characterBaseAttack + $weaponBaseAttack) * (1 + ($totalAttackPercent / 100))) + $totalFlatAttack;
	}

	private function sortDamageCalculations($damageCalculations)
	{
		usort($damageCalculations, function($a, $b)
		{
			// We'll sort by average damage
			return $b['averageDamage'] - $a['averageDamage'];
		});

		return $damageCalculations;
	}

	private function outputTopResults($calculations)
	{
		$counter = 1;

		foreach ($calculations AS $calculation)
		{
			echo '<h3>' . $counter . '. ' . $calculation['name'] . '</h3>';
			echo 'Average Damage per hit: <b>' . $calculation['averageDamage'] . '</b>';
			echo '<br><br>';
			echo 'Normal hit damage: ' . $calculation['damage'];
			echo '<br>';
			echo 'Critical hit damage: ' . $calculation['critDamage'];
			echo '<br><br>';

			echo 'Total attack: ' . $calculation['totalAttack'];
			echo '<br>';
			echo 'Crit rate: ' . $calculation['critRateStat'];
			echo '<br>';
			echo 'Crit damage: ' . $calculation['critDamageStat'];
			echo '<br><br>';

			echo 'Energy recharge: ' . $calculation['energyRecharge'];
			echo '<br>';
			echo 'Elemental mastery: ' . $calculation['elementalMastery'];
			echo '<br><br>';

			foreach ($calculation['setPieces'] AS $setName => $setPieces)
			{
				echo $setName . ': ' . $setPieces;
				echo "<br>";
			}

			$counter++;
		}
	}
}
