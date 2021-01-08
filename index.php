<?php

use StatStick\Artifact;
use StatStick\ArtifactCollection;
use StatStick\Character;
use StatStick\Weapon;
use Calculator\Calculator;

// Quick and dirty autoload our imports
spl_autoload_register(function($className) {
	include_once __DIR__ . '/' . $className . '.php';
});

// Create character
$ganyu = new Character('Ganyu', 335);
$ganyu->addDamageBonus(38.4);

// Create Skyward harp object
$skywardHarp = new Weapon(674);
$skywardHarp->addCritRate(22.1)
	->addCritDamage(20);

// Create Amos Bow object
$amosBow = new Weapon(608);
$amosBow->addAttackPercent(49.6)
	->addDamageBonus(12)
	->addDamageBonus(24); // Assumes 3 stacks of secondary refine effect

// Create artifacts
$flower = new Artifact;
$flower->addCritRate(7)
	->addCritDamage(10.1);

$feather = new Artifact;
$feather->addFlatAttack(311)
	->addCritRate(7)
	->addCritDamage(10.1);

$hourglass = new Artifact;
$hourglass->addAttackPercent(46.6)
	->addFlatAttack(30)
	->addAttackPercent(15.1)
	->addCritRate(20);

$goblet = new Artifact;
$goblet->addDamageBonus(46.6)
	->addCritRate(7)
	->addAttackPercent(15.1);

$circlet = new Artifact;
$circlet->addCritDamage(62.2)
	->addAttackPercent(15.1)
	->addCritDamage(10.1);

// Create artifact set
$artifactSet = new ArtifactCollection;

// Add artifacts to set
$artifactSet->addArtifact($flower);
$artifactSet->addArtifact($feather);
$artifactSet->addArtifact($hourglass);
$artifactSet->addArtifact($goblet);
$artifactSet->addArtifact($circlet);

// Add set effects
$artifactSet->addDamageBonus(15);
$artifactSet->addAttackPercent(18);

// Calculate Skyward Harp damage
$calculator = new Calculator($ganyu, $skywardHarp, $artifactSet);
$calculator->calculateDamage();

// Calculate Amos Bow damage
$calculatorTwo = new Calculator($ganyu, $amosBow, $artifactSet);
$calculatorTwo->calculateDamage();
