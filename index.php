<?php

use StatStick\BaseStatStick;
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
$ganyu->addCritDamage(38.4);

// Create Skyward harp object
$skywardHarp = new Weapon('Skyward Harp', 674);
$skywardHarp->addCritRate(22.1)
	->addCritDamage(20);

// Create Amos Bow object
$amosBow = new Weapon('Amos Bow', 608);
$amosBow->addAttackPercent(49.6)
	->addDamageBonus(12)
	->addDamageBonus(40); // Assumes effect maxes out on frostflake arrow blooms

// Create artifact set
$artifactSet = new ArtifactCollection;

$gladiator2SetBonus = new BaseStatStick();
$gladiator2SetBonus->addAttackPercent(18);

$icebreaker2SetBonus = new BaseStatStick();
$icebreaker2SetBonus->addDamageBonus(15);

$icebreaker4SetBonus = new BaseStatStick();
$icebreaker4SetBonus->addCritRate(20);

$artifactSet->addSetEffect('gladiator', 2, $gladiator2SetBonus);
$artifactSet->addSetEffect('icebreaker', 2, $icebreaker2SetBonus);
$artifactSet->addSetEffect('icebreaker', 4, $icebreaker4SetBonus);

// Create Flower artifacts
$noblesseFlower = new Artifact('Noblesse Flower');
$noblesseFlower->addCritRate(6.2)
	->addCritDamage(15.5)
	->addFlatAttack(47);

$gladiatorFlowerOne = new Artifact('1st Gladiator Flower', 'gladiator');
$gladiatorFlowerOne->addEnergyRecharge(10.4)
	->addFlatAttack(14)
	->addCritRate(13.6)
	->addAttackPercent(4.7);

$gladiatorFlowerTwo = new Artifact('2nd Gladiator Flower', 'gladiator');
$gladiatorFlowerTwo->addFlatAttack(18)
	->addCritRate(13.6)
	->addAttackPercent(5.3)
	->addElementalMastery(44);

$icebreakerFlowerOne = new Artifact('1st Icebreaker Flower', 'icebreaker');
$icebreakerFlowerOne->addCritRate(3.9)
	->addCritDamage(6.2)
	->addAttackPercent(18.7);

$icebreakerFlowerTwo = new Artifact('2nd Icebreaker Flower', 'icebreaker');
$icebreakerFlowerTwo->addFlatAttack(37)
	->addCritDamage(14.8)
	->addAttackPercent(9.9);

// Add Flower artifacts
$artifactSet->addArtifact($noblesseFlower, 'flower');
$artifactSet->addArtifact($gladiatorFlowerOne, 'flower');
$artifactSet->addArtifact($gladiatorFlowerTwo, 'flower');
$artifactSet->addArtifact($icebreakerFlowerOne, 'flower');
$artifactSet->addArtifact($icebreakerFlowerTwo, 'flower');

// Create Feather artifacts
$gladiatorFeather = new Artifact('Gladiator Feather', 'gladiator');
$gladiatorFeather->addFlatAttack(311) // mainstat
	->addElementalMastery(63)
	->addCritRate(3.5)
	->addCritDamage(14);

$icebreakerFeather = new Artifact('Icebreaker Feather', 'icebreaker');
$icebreakerFeather->addFlatAttack(311) // mainstat
	->addCritDamage(5.4)
	->addCritRate(9.3)
	->addAttackPercent(11.1);

// Add Feather artifacts
$artifactSet->addArtifact($gladiatorFeather, 'feather');
$artifactSet->addArtifact($icebreakerFeather, 'feather');

// Create Hourglass artifacts
$bloodstainHourglass = new Artifact('Bloodstained Hourglass');
$bloodstainHourglass->addAttackPercent(46.6) // main stat
	->addFlatAttack(68)
	->addCritDamage(14.8)
	->addCritRate(6.2);

$icebreakerHourglassOne = new Artifact('1st Icebreaker Hourglass', 'icebreaker');
$icebreakerHourglassOne->addAttackPercent(46.6) // main stat
	->addCritRate(6.6)
	->addEnergyRecharge(11)
	->addCritDamage(11.7);

$icebreakerHourGlassTwo = new Artifact('2nd Icebreaker Hourglass', 'icebreaker');
$icebreakerHourGlassTwo->addAttackPercent(46.6) // main stat
	->addFlatAttack(18)
	->addCritDamage(20.2);

// Add Hourglass artifacts
$artifactSet->addArtifact($bloodstainHourglass, 'hourglass');
$artifactSet->addArtifact($icebreakerHourglassOne, 'hourglass');
$artifactSet->addArtifact($icebreakerHourGlassTwo, 'hourglass');

// Create Goblet artifacts
$gladiatorGoblet = new Artifact('Gladiator Goblet', 'gladiator');
$gladiatorGoblet->addDamageBonus(46.6) // main stat
	->addEnergyRecharge(10.4)
	->addAttackPercent(10.5)
	->addFlatAttack(31)
	->addCritDamage(12.4);

// Add Goblet artifacts
$artifactSet->addArtifact($gladiatorGoblet, 'goblet');

// Create Circlet artifacts
$noblesseCritDamageCirclet = new Artifact('Noblesse Crit Damage Circlet');
$noblesseCritDamageCirclet->addCritDamage(62.2) // main stat
	->addCritRate(10.1)
	->addAttackPercent(5.8);

$icebreakerCritdamageCirclet = new Artifact('Icebreaker Crit Damage Circlet', 'icebreaker');
$icebreakerCritdamageCirclet->addCritDamage(62.2) // main stat
	->addFlatAttack(19)
	->addEnergyRecharge(12.3)
	->addCritRate(13.2);

// Add Circlet artifacts
$artifactSet->addArtifact($noblesseCritDamageCirclet, 'circlet');
$artifactSet->addArtifact($icebreakerCritdamageCirclet, 'circlet');

// Set up calculator and calculate highest damage combinations
$calculator = new Calculator($ganyu, [$skywardHarp, $amosBow], $artifactSet);
$calculator->getHighestDamage();
