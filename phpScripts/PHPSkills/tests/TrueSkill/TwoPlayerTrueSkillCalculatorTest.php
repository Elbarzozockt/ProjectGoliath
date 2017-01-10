<?php namespace Moserware\Skills\Tests\TrueSkill;

require 'vendor/autoload.php';

use Moserware\Skills\Tests\TestCase;
use Moserware\Skills\TrueSkill\TwoPlayerTrueSkillCalculator;

class TwoPlayerTrueSkillCalculatorTest extends TestCase
{
    public function testTwoPlayerTrueSkillCalculator()
    {
        $calculator = new TwoPlayerTrueSkillCalculator();

        // We only support two players
        TrueSkillCalculatorTests::testAllTwoPlayerScenarios($this, $calculator);
    }
}